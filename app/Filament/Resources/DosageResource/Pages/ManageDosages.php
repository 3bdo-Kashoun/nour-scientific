<?php

namespace App\Filament\Resources\DosageResource\Pages;

use App\Filament\Resources\DosageResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDosages extends ManageRecords
{
    protected static string $resource = DosageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
             ->label('إضافة جرعة جديد')
            ->icon('heroicon-o-plus'),
        ];
    }
}
