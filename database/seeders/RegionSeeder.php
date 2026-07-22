<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regiones = [
            ['id' => 1, 'nombre' => 'REGIÓN I', 'sede' => 'TANTOYUCA'],
            ['id' => 2, 'nombre' => 'REGIÓN II', 'sede' => 'TUXPAN'],
            ['id' => 3, 'nombre' => 'REGIÓN III', 'sede' => 'POZA RICA'],
            ['id' => 4, 'nombre' => 'REGIÓN IV', 'sede' => 'MARTÍNEZ DE LA TORRE'],
            ['id' => 5, 'nombre' => 'REGIÓN V', 'sede' => 'XALAPA'],
            ['id' => 6, 'nombre' => 'REGIÓN VI', 'sede' => 'VERACRUZ'],
            ['id' => 7, 'nombre' => 'REGIÓN VII', 'sede' => 'CORDOBA'],
            ['id' => 8, 'nombre' => 'REGIÓN VIII', 'sede' => 'ORIZABA'],
            ['id' => 9, 'nombre' => 'REGIÓN IX', 'sede' => 'COSAMALOAPAN'],
            ['id' => 10, 'nombre' => 'REGIÓN X', 'sede' => 'SAN ANDRES TUXTLA'],
            ['id' => 11, 'nombre' => 'REGIÓN XI', 'sede' => 'MINATITLÁN'],
        ];

        foreach ($regiones as $region) {
            DB::table('regiones')->updateOrInsert(
                ['id' => $region['id']],
                [
                    'nombre' => $region['nombre'],
                    'sede' => $region['sede'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }

        $this->command->info('Regiones importadas correctamente.');
    }
}
