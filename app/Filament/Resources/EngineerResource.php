<?php

namespace App\Filament\Resources;

use App;
use App\Filament\Resources\EngineerResource\Pages;
use App\Filament\Resources\EngineerResource\RelationManagers;
use App\Models\Engineer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EngineerResource extends Resource
{
    protected static ?string $model = Engineer::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $modelLabel = 'مهندس';

    protected static ?string $pluralModelLabel = 'المهندسين';
    protected static ?string $navigationGroup = 'الإدارة والصلاحيات';

    protected static ?string $navigationLabel = 'المهندسين';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('الاسم')
                    ->maxLength(255),
                Forms\Components\TextInput::make('role')
                    ->required()
                    ->label('الوظيفة')
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->label('رقم الهاتف')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->label('البريد الإلكتروني')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->fontFamily('Tajwal')
                    ->label('الاسم'),
                Tables\Columns\TextColumn::make('role')
                    ->searchable()
                    ->fontFamily('Tajwal')
                    ->label('الوظيفة'),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->label('رقم الهاتف')
                    ->fontFamily('Tajwal')
                    ->extraAttributes(['style' => 'direction: ltr;']) // فقط لإصلاح ترتيب الرموز
                    ->alignment(\Filament\Support\Enums\Alignment::Right),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->label('البريد الإلكتروني')
                    ->fontFamily('Tajwal'),

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
                    ->color('danger'), // لون الحذف الأحمر
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
            'index' => Pages\ManageEngineers::route('/'),
        ];
    }
}
