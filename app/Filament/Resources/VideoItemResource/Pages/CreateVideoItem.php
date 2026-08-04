<?php

namespace App\Filament\Resources\VideoItemResource\Pages;

use App\Filament\Resources\VideoItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVideoItem extends CreateRecord
{
    protected static string $resource = VideoItemResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return VideoItemResource::processTranslatableData($data);
    }
}
