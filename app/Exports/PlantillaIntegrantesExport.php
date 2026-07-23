<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class PlantillaIntegrantesExport implements FromCollection, WithHeadings, WithTitle, ShouldAutoSize
{
    /**
     * Retorna una colección vacía ya que es solo una plantilla
     */
    public function collection()
    {
        return new Collection([]);
    }

    /**
     * Define los encabezados exactos en el orden A-M solicitado
     */
    public function headings(): array
    {
        return [
            'apellido_paterno',  // A
            'apellido_materno',  // B
            'nombre',            // C
            'genero',            // D
            'telefono',          // E
            'email',             // F
            'rfc',               // G
            'curp',              // H
            'funcion',           // I
            'fecha_sev',         // J
            'delegacion',        // K
            'nivel_integrante',  // L
            'numero_personal',   // M
        ];
    }

    /**
     * Nombre de la pestaña del Excel
     */
    public function title(): string
    {
        return 'Plantilla de Carga SIES56';
    }
}