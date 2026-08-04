<?php

namespace App\Filament\Resources\ExpertResource\Pages;

use App\Filament\Resources\ExpertResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpert extends CreateRecord
{
    protected static string $resource = ExpertResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return ExpertResource::processTranslatableData($data);
    }
}
