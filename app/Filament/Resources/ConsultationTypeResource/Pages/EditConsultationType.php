<?php

namespace App\Filament\Resources\ConsultationTypeResource\Pages;

use App\Filament\Resources\ConsultationTypeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditConsultationType extends EditRecord
{
    protected static string $resource = ConsultationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
