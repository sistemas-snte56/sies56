<?php

namespace App\Imports;

use App\Models\Integrante;
use Maatwebsite\Excel\Concerns\ToModel;

use App\Models\Adscripcion;
use App\Models\Delegacion;
use App\Models\NivelIntegrante;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
// use Maatwebsite\Excel\Concerns\WithBatchInserts;
// use Maatwebsite\Excel\Concerns\WithUpserts;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class IntegrantesImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return DB::transaction(function () use ($row) {
            // 1. Buscamos o creamos al Integrante (La Persona)
            $integrante = Integrante::updateOrCreate(
                ['rfc' => $row['rfc']],
                [
                    'nombre'          => $row['nombre'],
                    'apellido_paterno'=> $row['apellido_paterno'],
                    'apellido_materno'=> $row['apellido_materno'],
                    'curp'            => $row['curp'],
                    'numero_personal' => $row['numero_personal'],
                    'genero'          => $row['genero'], // M o H
                    'estatus_global'  => 'ACTIVO',
                ]
            );

            // 2. Buscamos el ID de la Delegación por nombre (ej: D-II-59)
            $delegacion = Delegacion::where('delegacion', trim($row['delegacion']))->first();
            
            // 3. Buscamos el ID del Nivel de Integrante (ej: PRIMARIAS)
            $nivel = NivelIntegrante::where('nombre', trim($row['nivel_sindical']))->first();

            // 4. Procesamiento de Fecha (Columna J: fecha_sev)
            $fechaSev = null;
            if (!empty($row['fecha_sev'])) {
                try {
                    // Maneja tanto el formato fecha de Excel como el texto YYYY-MM-DD
                    $fechaSev = is_numeric($row['fecha_sev']) 
                        ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_sev'])
                        : Carbon::parse($row['fecha_sev']);
                } catch (\Exception $e) {
                    $fechaSev = null;
                }
            }            

            // 5. Creamos la Adscripción a la Delegación
            if ($delegacion && $nivel) {
                Adscripcion::create([
                    'integrante_id'       => $integrante->id,
                    'delegacion_id'       => $delegacion->id,
                    'nivel_integrante_id' => $nivel->id,
                    'funcion'             => trim($row['funcion']),
                    'estatus_adscripcion' => 'ACTIVO',
                ]);
            }

            return $integrante;
        });
    }

    public function rules(): array
    {
        return [
            // 'rfc' => 'required|string|size:13',
            // 'curp' => 'required|string|size:18',
            // 'numero_personal' => 'required',
            // 'nombre' => 'required',
            'delegacion' => 'required|exists:delegaciones,delegacion',
            // 'nivel_sindical' => 'required|exists:nivel_integrantes,nombre',
        ];
    }
}
