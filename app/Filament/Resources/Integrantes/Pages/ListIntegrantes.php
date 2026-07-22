<?php

namespace App\Filament\Resources\Integrantes\Pages;

use App\Filament\Resources\Integrantes\IntegranteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIntegrantes extends ListRecords
{
    protected static string $resource = IntegranteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
