<?php

namespace App\Filament\Resources\TrainingBagResource\Pages;

use App\Filament\Resources\TrainingBagResource;
use App\Support\TrainingBagSections;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingBag extends EditRecord
{
    protected static string $resource = TrainingBagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data = TrainingBagResource::expandTranslatableData($data, $this->getRecord());

        if (! empty($data['content_sections']) && is_array($data['content_sections'])) {
            $data['content_sections'] = TrainingBagSections::normalizeRichBlocksForForm($data['content_sections']);
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (! empty($data['content_sections']) && is_array($data['content_sections'])) {
            $data['content_sections'] = TrainingBagSections::normalizeRichBlocksForStorage($data['content_sections']);
        }

        return TrainingBagResource::processTranslatableData($data);
    }
}
