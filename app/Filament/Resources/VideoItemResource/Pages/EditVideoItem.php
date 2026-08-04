<?php

namespace App\Filament\Resources\VideoItemResource\Pages;

use App\Filament\Resources\VideoItemResource;
use Filament\Resources\Pages\EditRecord;

class EditVideoItem extends EditRecord
{
    protected static string $resource = VideoItemResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return VideoItemResource::expandTranslatableData($data, $this->record);
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return VideoItemResource::processTranslatableData($data);
    }
}
