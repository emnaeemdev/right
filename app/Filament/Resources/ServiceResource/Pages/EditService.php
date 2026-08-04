<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditService extends EditRecord
{
    protected static string $resource = ServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return ServiceResource::expandTranslatableData($data, $this->getRecord());
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return ServiceResource::processTranslatableData($data);
    }
}
