<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DosageResource\Pages;
use App\Filament\Resources\DosageResource\RelationManagers;
use App\Models\Dosage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DosageResource extends Resource
{
    protected static ?string $model = Dosage::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'إدارة المخزون';
    protected static ?string $navigationLabel = 'إدارة الجرعات';
    protected static ?string $pluralModelLabel = 'جرعات';
    protected static ?string $modelLabel = 'جرعة';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('unit_name')
                    ->required()
                    ->label('اسم الوحدة')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unit_name')
                    ->label('اسم الوحدة')
                    ->searchable(),

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
            'index' => Pages\ManageDosages::route('/'),
        ];
    }
}
