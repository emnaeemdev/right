<?php

namespace App\Filament\Resources\TrainingActivityResource\Pages;

use App\Filament\Resources\TrainingActivityResource;
use Filament\Resources\Pages\EditRecord;

class EditTrainingActivity extends EditRecord
{
    protected static string $resource = TrainingActivityResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return TrainingActivityResource::expandTranslatableData($data, $this->getRecord());
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return TrainingActivityResource::processTranslatableData($data);
    }
}
