<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    // تغيير الأيقونة لأيقونة "منتجات/سلة" وتغيير العنوان الجانبي
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $modelLabel = 'منتج';
    protected static ?string $pluralModelLabel = 'المنتجات';
    protected static ?string $navigationGroup = 'إدارة المخزون';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات المنتج الأساسية')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم المنتج')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('code')
                            ->label('كود المنتج')
                            ->required()
                            ->maxLength(255),

                        // تحويل الـ ID إلى قائمة منسدلة للأصناف
                        Forms\Components\Select::make('category_id')
                            ->label('الصنف')
                            ->relationship('category', 'name') // يفترض وجود علاقة في الموديل باسم category
                            ->searchable()
                            ->preload()
                            ->required(),
                            Forms\Components\Select::make('company_id')
                            ->label('الشركة')
                            ->relationship('company', 'name') // يفترض وجود علاقة في الموديل باسم category
                            ->searchable()
                            ->preload()
                            ->required(),

                        // تحويل الـ ID إلى قائمة منسدلة للجرعات
                        Forms\Components\Select::make('dosage_id')
                            ->label('الجرعة')
                            ->relationship('dosage', 'unit_name') // يفترض وجود علاقة في الموديل باسم dosage
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('التفاصيل المالية والمخزون')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('السعر')
                            ->required()
                            ->numeric()
                            ->prefix('LYD'),

                        Forms\Components\TextInput::make('dos_value')
                            ->label('قيمة الجرعة')
                            ->required()
                            ->numeric(),

                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('الكمية في المخزن')
                            ->required()
                            ->numeric(),

                        Forms\Components\DatePicker::make('expiry_date')
                            ->label('تاريخ الصلاحية')
                            ->required(),
                    ])->columns(2),

                Forms\Components\FileUpload::make('image')
                    ->label('صورة المنتج')
                    ->image()
                    ->directory('products')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('الصورة'),

                Tables\Columns\TextColumn::make('name')
                    ->label('اسم المنتج')
                    ->searchable(),

                Tables\Columns\TextColumn::make('category.name') // عرض اسم القسم بدل الـ ID
                    ->label('الصنف')
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('السعر')
                    ->money('LYD')

                    ->sortable(),

                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('المخزون')

                    ->sortable(),

                Tables\Columns\TextColumn::make('expiry_date')
                    ->label('تاريخ الصلاحية')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('code')
                    ->label('الكود')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
               Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->icon('heroicon-m-pencil-square')
                    ->color('info'),

                Tables\Actions\DeleteAction::make()
                    ->iconButton()
                    ->icon('heroicon-m-trash') // أيقونة السلة الحمراء
                    ->color('danger'),
            ])

            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProducts::route('/'),
        ];
    }
}
