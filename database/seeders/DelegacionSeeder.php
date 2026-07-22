<?php

namespace Database\Seeders;

use App\Models\Delegacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DelegacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/delegaciones.csv');

        // leer archivos en el excel
        if(! File::exists($path)) {
            $this->command->warn("Archivo no encontrado: {$path}");
            return;
        }

        // Omitir cabecera de CSV
        $rows = collect(File::lines($path))
            ->skip(1)
            ->filter()
            ->map(fn (string $line) => str_getcsv($line));
            
        // Líneas vacías
        foreach ($rows as $row) {
            Delegacion::updateOrCreate(
                ['id' => $row[0]],
                [
                    'region_id'   => $row[1],
                    'delegacion'  => $row[2],
                    'sede'        => $row[3],
                    'nivel_delegacion_id'    => $row[4],
                ],
            );  
        }
        
        $this->command->info('Delegaciones importadas correctamente.');
    }
}
