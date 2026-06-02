<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    // تغيير الأيقونة لأيقونة "بناية/شركة" وتعريب العناوين
    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $modelLabel = 'شركة';
    protected static ?string $pluralModelLabel = 'الشركات';
    protected static ?string $navigationGroup = 'إدارة المخزون';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('معلومات الشركة')
                    ->description('أدخل البيانات الأساسية للشركة المصنعة أو الموردة')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الشركة')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->label('البريد الإلكتروني')
                            ->email()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('phone')
                            ->label('رقم الهاتف')
                            ->tel()
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('website')
                            ->label('الموقع الإلكتروني')
                            ->url() // للتأكد من صيغة الرابط
                            ->maxLength(255)
                            ->default(null),
                    ])->columns(2),

                Forms\Components\Section::make('العنوان والشعار')
                    ->schema([
                        Forms\Components\TextInput::make('country')
                            ->label('الدولة')
                            ->maxLength(255)
                            ->default(null),

                        Forms\Components\TextInput::make('city')
                            ->label('المدينة')
                            ->maxLength(255)
                            ->default(null),

                        FileUpload::make('image')
                            ->label('شعار الشركة')
                            ->image()
                            ->directory('company-images')
                            ->visibility('public')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\View::make('filament.pages.company-card-row')
                    ->schema([
                        Tables\Columns\TextColumn::make('name')
                            ->label('اسم الشركة')
                            ->searchable()
                            ->sortable(),

                        Tables\Columns\TextColumn::make('email')
                            ->label('البريد الإلكتروني')
                            ->searchable(),

                        Tables\Columns\TextColumn::make('phone')
                            ->label('رقم الهاتف')
                            ->searchable(),

                        Tables\Columns\TextColumn::make('country')
                            ->label('الدولة')
                            ->searchable()
                            ->sortable(),
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
                    ->button()
                    ->label('تعديل')
                    ->icon('heroicon-m-pencil-square')
                    ->color('primary')
                    ->extraAttributes([
                        'class' => 'company-edit-btn flex-grow justify-center py-2.5 rounded-xl text-sm font-bold shadow-sm',
                    ]),

                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->iconButton()
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->extraAttributes([
                        'class' => 'company-delete-btn p-2.5 rounded-xl bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-950/20 dark:hover:bg-red-900/30 dark:text-red-400 border border-transparent shadow-sm',
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
            'index' => Pages\ManageCompanies::route('/'),
        ];
    }
}
