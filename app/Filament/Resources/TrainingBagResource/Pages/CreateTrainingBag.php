<?php

namespace App\Filament\Resources\TrainingBagResource\Pages;

use App\Filament\Resources\TrainingBagResource;
use App\Support\TrainingBagSections;
use Filament\Resources\Pages\CreateRecord;

class CreateTrainingBag extends CreateRecord
{
    protected static string $resource = TrainingBagResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (! empty($data['content_sections']) && is_array($data['content_sections'])) {
            $data['content_sections'] = TrainingBagSections::normalizeRichBlocksForStorage($data['content_sections']);
        }

        return TrainingBagResource::processTranslatableData($data);
    }
}
