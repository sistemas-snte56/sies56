<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class NivelIntegranteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            ['nombre' => 'PREESCOLAR'],
            ['nombre' => 'EDUCACION ESPECIAL'],
            ['nombre' => 'PRIMARIAS'],
            ['nombre' => 'SECUNDARIAS'],
            ['nombre' => 'PENSIONADOS Y JUBILADOS'],
            ['nombre' => 'EDUCACION FISICA'],
            ['nombre' => 'NIVELES ESPECIALES'],
            ['nombre' => 'TELESECUNDARIAS'],
            ['nombre' => 'PAAE'],
            ['nombre' => 'BACHILLERATO'],
            ['nombre' => 'TELEBACHILLERATO'],
            ['nombre' => 'NORMALES Y UPV'],
        ];

        DB::table('nivel_integrantes')->insert($niveles);
        
        $this->command->info('Niveles de integrantes importados correctamente.');
    }
}
