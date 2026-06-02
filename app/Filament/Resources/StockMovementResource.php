<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockMovementResource\Pages;
use App\Models\StockMovement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StockMovementResource extends Resource
{
    protected static ?string $model = StockMovement::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';
    protected static ?string $navigationLabel = 'حركات المخزن';
    protected static ?string $modelLabel = 'حركة مخزن';
    protected static ?string $pluralModelLabel = 'حركات المخزن';
    protected static ?string $navigationGroup = 'إدارة المبيعات والمخزن';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->label('المنتج'),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->label('الكمية (موجبة للدخول، سالبة للخروج)'),
                Forms\Components\Select::make('type')
                    ->options([
                        'in' => 'دخول / توريد / إرجاع',
                        'out' => 'خروج / بيع / تلف',
                    ])
                    ->required()
                    ->label('نوع الحركة'),
                Forms\Components\TextInput::make('reason')
                    ->required()
                    ->maxLength(255)
                    ->label('السبب / التفاصيل'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('الكمية')
                    ->sortable()
                    ->badge()
                    ->color(fn ($state, $record): string => $record->type === 'in' ? 'success' : 'danger')
                    ->formatStateUsing(function ($state, $record): string {
                        $absVal = abs((int) $state);
                        return $record->type === 'in' ? '+' . $absVal : '-' . $absVal;
                    }),
                Tables\Columns\TextColumn::make('type')
                    ->label('نوع الحركة')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'in' ? 'success' : 'danger')
                    ->formatStateUsing(fn (string $state): string => $state === 'in' ? 'دخول' : 'خروج'),
                Tables\Columns\TextColumn::make('reason')
                    ->label('السبب / التفاصيل')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('التاريخ والوقت')
                    ->dateTime()
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->with(['product']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockMovements::route('/'),
            'create' => Pages\CreateStockMovement::route('/create'),
            'edit' => Pages\EditStockMovement::route('/{record}/edit'),
        ];
    }
}
