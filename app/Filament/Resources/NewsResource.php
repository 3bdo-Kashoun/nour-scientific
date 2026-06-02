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
    protected static ?string $modelLabel = 'خبر';
    protected static ?string $pluralModelLabel = 'الأخبار';

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
                Tables\Columns\Layout\View::make('filament.pages.news-card-row')
                    ->schema([
                        Tables\Columns\TextColumn::make('title')
                            ->label('عنوان الخبر')
                            ->searchable()
                            ->sortable(),

                        Tables\Columns\TextColumn::make('discreption')
                            ->label('الوصف')
                            ->searchable(),
                    ]),
            ])
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('تعديل')
                    ->icon('heroicon-m-pencil-square')
                    ->button()
                    ->color('primary')
                    ->extraAttributes([
                        'class' => 'news-edit-btn flex-1 py-2.5 rounded-xl border border-transparent shadow-sm',
                    ]),

                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->iconButton()
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->extraAttributes([
                        'class' => 'news-delete-btn p-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-950/20 dark:hover:bg-red-900/30 dark:text-red-400 border border-transparent shadow-sm',
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('حذف المحدد'),
                ])->label('عمليات جماعية'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageNews::route('/'),
        ];
    }
}
