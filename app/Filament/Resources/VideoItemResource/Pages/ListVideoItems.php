<?php

namespace App\Filament\Resources\VideoItemResource\Pages;

use App\Filament\Resources\VideoItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideoItems extends ListRecords
{
    protected static string $resource = VideoItemResource::class;

    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
