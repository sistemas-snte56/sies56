<?php

namespace App\Filament\Resources\Integrantes\Pages;

use App\Filament\Resources\Integrantes\IntegranteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditIntegrante extends EditRecord
{
    protected static string $resource = IntegranteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
