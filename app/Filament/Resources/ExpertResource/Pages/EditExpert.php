<?php

namespace App\Filament\Resources\ExpertResource\Pages;

use App\Filament\Resources\ExpertResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExpert extends EditRecord
{
    protected static string $resource = ExpertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return ExpertResource::expandTranslatableData($data, $this->getRecord());
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return ExpertResource::processTranslatableData($data);
    }
}
