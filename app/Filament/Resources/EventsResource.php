<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventsResource\Pages;
use App\Filament\Resources\EventsResource\RelationManagers;
use App\Models\Events;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EventsResource extends Resource
{
    protected static ?string $model = Events::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $modelLabel = 'حدث';
    protected static ?string $navigationGroup = 'المحتوى التفاعلي';
    protected static ?string $pluralModelLabel = 'الأحداث';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->label('عنوان الحدث')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start_date')
                    ->required()
                    ->label('تاريخ البدء'),
                Forms\Components\DatePicker::make('end_date')
                    ->required()
                    ->label('تاريخ النهاية'),
                Forms\Components\TextInput::make('city')
                    ->required()
                    ->maxLength(255)
                    ->label('المدينة'),
                Forms\Components\TextInput::make('booth')
                    ->maxLength(255)
                    ->default(null)
                    ->label('رقم الجناح'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('قادم')
                    ->label('الحالة'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('عنوان الحدث')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->label('تاريخ اليدء')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->label('تاريخ النهاية')
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('المدينة')
                    ->searchable(),
                Tables\Columns\TextColumn::make('booth')
                    ->label('رقم الجناح')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('الحالة')
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
            'index' => Pages\ManageEvents::route('/'),
        ];
    }
}
