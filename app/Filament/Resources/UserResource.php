<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $slug = 'users';
    protected static ?string $navigationLabel = 'إدارة المستخدمين';
    protected static ?string $modelLabel = 'مستخدم';
    protected static ?string $pluralModelLabel = 'إدارة المستخدمين';
    protected static ?string $navigationGroup = 'الإدارة والصلاحيات';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->label('الاسم')
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->label('البريد الإلكتروني')
                    ->maxLength(255),


                Forms\Components\Toggle::make('is_admin')
                    ->label('مدير')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم'),

                Tables\Columns\TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->label('تم التحقق من البريد')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_admin')
                    ->boolean()
                    ->label('مدير'),
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
            'index' => Pages\ManageUsers::route('/'),
        ];
    }
}
