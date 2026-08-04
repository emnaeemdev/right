<?php

namespace App\Filament\Resources\PublicationResource\Pages;

use App\Filament\Resources\PublicationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPublication extends EditRecord
{
    protected static string $resource = PublicationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return PublicationResource::expandTranslatableData($data, $this->getRecord());
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return PublicationResource::processTranslatableData($data);
    }
}
