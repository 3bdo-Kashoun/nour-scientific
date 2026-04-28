<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Filament\Resources\NewsResource\RelationManagers;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationLabel = 'إدارة الأخبار';
   protected static ?string $navigationGroup = 'المحتوى التفاعلي';
    protected static ?string $modelLabel='خبر';
    protected static ?string $pluralModelLabel='إدارة الأخبار';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->label('عنوان الخبر'),
                Forms\Components\Textarea::make('discreption')
                    ->required()
                    ->columnSpanFull()
                    ->label('وصف مختصر للخبر'),
                    FileUpload::make('image')
                ->label('صورة الخبر')
                ->image() // يتأكد أن الملف المرفوع صورة
                ->directory('news-images') // اسم المجلد اللي حتتخزن فيه الصور داخل الـ storage
                ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->label('عنوان الخبر'),

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
            'index' => Pages\ManageNews::route('/'),
        ];
    }
}
