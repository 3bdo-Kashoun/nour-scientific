<?php

namespace App\Filament\Resources\EngineerResource\Pages;

use App\Filament\Resources\EngineerResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEngineers extends ManageRecords
{
    protected static string $resource = EngineerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('إضافة مهندس')
            ->icon('heroicon-o-plus')
            ->extraAttributes(['style' => 'padding: 0.5rem 1rem; ']),
        ];
    }
}
