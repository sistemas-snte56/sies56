<?php

namespace App\Filament\Resources\Integrantes\Pages;

use App\Filament\Resources\Integrantes\IntegranteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use App\Imports\IntegrantesImport;
use App\Exports\PlantillaIntegrantesExport;

class ListIntegrantes extends ListRecords
{
    protected static string $resource = IntegranteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('importarExcel')
                ->label('Carga Masiva')
                ->icon('heroicon-o-document-arrow-up')
                ->color('success')
                ->form([
                    FileUpload::make('archivo_excel')
                        ->label('Selecciona el archivo Excel (.xlsx)')
                        ->required()
                        ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet']),
                ])
                ->action(function (array $data) {
                    try {
                        Excel::import(new IntegrantesImport, storage_path('app/public/' . $data['archivo_excel']));
                        
                        Notification::make()
                            ->title('Carga completada con éxito')
                            ->success()
                            ->send();
                    } catch (\Exception $e) {
                        Notification::make()
                            ->title('Error en la carga')
                            ->body('Verifique que los datos (RFC/CURP/Delegaciones) sean correctos.')
                            ->danger()
                            ->send();
                    }
                }),   
                
            // Botón para Descargar Plantilla
            Action::make('descargarPlantilla')
                ->label('Descargar Formato')
                ->icon('heroicon-o-table-cells')
                ->color('info')
                ->action(fn () => Excel::download(new PlantillaIntegrantesExport, 'formato_padron_sies56.xlsx')),                
        ];
    }
}
