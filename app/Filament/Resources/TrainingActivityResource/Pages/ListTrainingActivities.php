<?php

namespace App\Filament\Resources\TrainingActivityResource\Pages;

use App\Filament\Resources\TrainingActivityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrainingActivities extends ListRecords
{
    protected static string $resource = TrainingActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
