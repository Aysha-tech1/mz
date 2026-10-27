<?php

namespace App\Filament\Resources\ConsultationTypeResource\Pages;

use App\Filament\Resources\ConsultationTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListConsultationTypes extends ListRecords
{
    protected static string $resource = ConsultationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
