<?php

namespace App\Filament\Resources\TrainingActivityResource\Pages;

use App\Filament\Resources\TrainingActivityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTrainingActivity extends CreateRecord
{
    protected static string $resource = TrainingActivityResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return TrainingActivityResource::processTranslatableData($data);
    }
}
