<?php

namespace App\Filament\Resources\EventsResource\Pages;

use App\Filament\Resources\EventsResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEvents extends ManageRecords
{
    protected static string $resource = EventsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('إضافة حدث جديد')
            ->icon('heroicon-o-plus'),
        ];
    }
}
