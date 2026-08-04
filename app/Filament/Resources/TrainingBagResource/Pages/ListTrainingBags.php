<?php

namespace App\Filament\Resources\TrainingBagResource\Pages;

use App\Filament\Resources\TrainingBagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingBags extends ListRecords
{
    protected static string $resource = TrainingBagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
