<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'إدارة الطلبات';
    protected static ?string $modelLabel = 'طلب';
    protected static ?string $pluralModelLabel = 'إدارة الطلبات';
    protected static ?string $navigationGroup = 'إدارة المبيعات والمخزن';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name', fn ($query) => $query->where('is_admin', false))
                    ->required()
                    ->label('العميل'),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(255)
                    ->label('رقم الهاتف'),
                Forms\Components\Toggle::make('delivery_requested')
                    ->required()
                    ->label('طلب توصيل (حجز إن كانت معطلة)'),
                Forms\Components\TextInput::make('delivery_price')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('سعر التوصيل'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'قيد الانتظار',
                        'cancelled' => 'ملغية',
                        'in_delivery' => 'قيد التوصيل',
                        'sold' => 'تم البيع',
                    ])
                    ->required()
                    ->label('حالة الطلبية'),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->default(0.00)
                    ->label('السعر الإجمالي (د.ل)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('رقم الطلب')
                    ->formatStateUsing(fn ($state) => '#ORD-' . str_pad($state, 3, '0', STR_PAD_LEFT))
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('العميل')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('رقم الهاتف')
                    ->searchable(),
                Tables\Columns\IconColumn::make('delivery_requested')
                    ->boolean()
                    ->label('طلب توصيل'),
                 Tables\Columns\TextColumn::make('delivery_price')
                    ->label('سعر التوصيل')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . ' د.ل')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        'in_delivery' => 'info',
                        'sold' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'قيد الانتظار',
                        'cancelled' => 'ملغية',
                        'in_delivery' => 'قيد التوصيل',
                        'sold' => 'تم البيع',
                        default => $state,
                    })
                    ->action(
                        Tables\Actions\Action::make('updateStatus')
                            ->disabled(fn (Order $record): bool => !in_array($record->status, ['pending', 'in_delivery']))
                            ->label('تعديل حالة الطلبية')
                            ->modalHeading('تعديل حالة الطلبية')
                            ->modalWidth('md')
                            ->form([
                                Forms\Components\Select::make('status')
                                    ->label('الحالة الجديدة')
                                    ->options(function (Order $record) {
                                        if ($record->status === 'pending') {
                                            $options = [
                                                'pending' => 'قيد الانتظار',
                                                'cancelled' => 'ملغية',
                                                'sold' => 'تم البيع',
                                            ];
                                            if ($record->delivery_requested) {
                                                $options['in_delivery'] = 'قيد التوصيل';
                                            }
                                            return $options;
                                        } elseif ($record->status === 'in_delivery') {
                                            return [
                                                'in_delivery' => 'قيد التوصيل',
                                                'cancelled' => 'ملغية',
                                                'sold' => 'تم البيع',
                                            ];
                                        }
                                        return [
                                            $record->status => $record->status,
                                        ];
                                    })
                                    ->required(),
                            ])
                            ->fillForm(fn (Order $record): array => [
                                'status' => $record->status,
                            ])
                            ->action(function (Order $record, array $data): void {
                                $oldStatus = $record->status;
                                $newStatus = $data['status'];

                                if ($oldStatus === $newStatus) {
                                    return;
                                }

                                \DB::transaction(function () use ($record, $oldStatus, $newStatus) {
                                    $orderNo = '#ORD-' . str_pad($record->id, 3, '0', STR_PAD_LEFT);
                                    $clientName = $record->user?->name ?? 'غير معروف';

                                    // Apply stock rules based on transitions
                                    if ($oldStatus === 'pending' && $newStatus === 'cancelled') {
                                        // Pending -> Cancelled: increment stock, log return
                                        foreach ($record->products as $product) {
                                            $qty = $product->pivot->quantity;
                                            $product->increment('stock_quantity', $qty);
                                            $product->stockMovements()->create([
                                                'quantity' => $qty,
                                                'type' => 'in',
                                                'reason' => "إرجاع بضاعة صالحة للمخزن بعد إلغاء الطلبية من الزبون {$clientName}",
                                            ]);
                                        }
                                    } elseif ($oldStatus === 'pending' && $newStatus === 'in_delivery') {
                                        // Pending -> In Delivery: decrement stock, log delivery
                                        foreach ($record->products as $product) {
                                            $qty = $product->pivot->quantity;
                                            $product->decrement('stock_quantity', $qty);
                                            $product->stockMovements()->create([
                                                'quantity' => $qty,
                                                'type' => 'out',
                                                'reason' => "شحن وتوصيل للزبون {$clientName} - طلبية رقم {$orderNo}",
                                            ]);
                                        }
                                    } elseif ($oldStatus === 'in_delivery' && $newStatus === 'cancelled') {
                                        // In Delivery -> Cancelled: increment stock, log return
                                        foreach ($record->products as $product) {
                                            $qty = $product->pivot->quantity;
                                            $product->increment('stock_quantity', $qty);
                                            $product->stockMovements()->create([
                                                'quantity' => $qty,
                                                'type' => 'in',
                                                'reason' => "إرجاع بضاعة صالحة للمخزن بعد إلغاء الطلبية من الزبون {$clientName}",
                                            ]);
                                        }
                                    } elseif ($oldStatus === 'pending' && $newStatus === 'sold') {
                                        // Pending -> Sold: decrement stock, log sale
                                        foreach ($record->products as $product) {
                                            $qty = $product->pivot->quantity;
                                            $product->decrement('stock_quantity', $qty);
                                            $product->stockMovements()->create([
                                                'quantity' => $qty,
                                                'type' => 'out',
                                                'reason' => "بيع مباشر للزبون {$clientName} - طلبية رقم {$orderNo}",
                                            ]);
                                        }
                                    }

                                    // Update the order status
                                    $record->update(['status' => $newStatus]);
                                });
                            })
                    ),
                Tables\Columns\TextColumn::make('total_price')
                    ->label('السعر الإجمالي')
                    ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . ' د.ل')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الطلب')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                    ->icon('heroicon-m-eye')
                    ->color('success'),
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->icon('heroicon-m-pencil-square')
                    ->color('info'),
                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->icon('heroicon-m-trash')
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('معلومات الطلب الأساسية')
                    ->schema([
                        TextEntry::make('id')
                            ->label('رقم الطلب')
                            ->formatStateUsing(fn ($state) => '#ORD-' . str_pad($state, 3, '0', STR_PAD_LEFT)),
                        TextEntry::make('user.name')
                            ->label('العميل'),
                        TextEntry::make('phone')
                            ->label('رقم الهاتف'),
                        TextEntry::make('status')
                            ->label('الحالة')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                'in_delivery' => 'info',
                                'sold' => 'success',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'pending' => 'قيد الانتظار',
                                'cancelled' => 'ملغية',
                                'in_delivery' => 'قيد التوصيل',
                                'sold' => 'تم البيع',
                                default => $state,
                            }),
                        TextEntry::make('delivery_requested')
                            ->label('طلب التوصيل')
                            ->formatStateUsing(fn ($state) => $state ? 'نعم (توصيل)' : 'لا (حجز واستلام شخصي)'),
                        TextEntry::make('delivery_price')
                            ->label('سعر التوصيل')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . ' د.ل'),
                        TextEntry::make('total_price')
                            ->label('السعر الإجمالي للطلب')
                            ->formatStateUsing(fn ($state) => number_format((float) $state, 2) . ' د.ل'),
                        TextEntry::make('created_at')
                            ->label('تاريخ ووقت الطلب')
                            ->dateTime(),
                    ])
                    ->columns(2),

                Section::make('تفاصيل المنتجات المشتراة')
                    ->schema([
                        ViewEntry::make('products')
                            ->label('')
                            ->view('filament.pages.order-products-view')
                    ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
