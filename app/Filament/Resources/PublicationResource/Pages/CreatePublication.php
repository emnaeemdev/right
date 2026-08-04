<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePublication extends CreateRecord
{
    protected static string $resource = PublicationResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return PublicationResource::processTranslatableData($data);
    }
}
