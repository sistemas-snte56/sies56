<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class NivelDelegacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $niveles = [
            'ADMINISTRATIVOS EDUCACIÓN FÍSICA', 'ADMINISTRATIVOS OFICINAS CENTRALES',
            'ADMINISTRATIVOS TELEBACHILLERATO', 'ADMINISTRATIVOS Y DOCENTES DE LA D.G.B.',
            'BACHILLEARTO RICARDO FLORES MAGÓN MIXTO', 'BACHILLERATO',
            'BACHILLERATO ARTÍCULO 3° DIURNA', 'BACHILLERATO ANTONIO MARÍA DE RIVERA',
            'BACHILLERATO ANTONIO MARÍA DE RIVERA MIXTA', 'BACHILLERATO ANTONIO MARÍA DE RIVERA VESPERTINA',
            'BACHILLERATO DE VERACRUZ VESPERTINO', 'BACHILLERATO JOAQUÍN RAMÍREZ CABAÑAS MIXTA',
            'BACHILLERATO SABATINO', 'BACHILLERATOS MATUTINOS', 'BACHILLERATOS VESPERTINOS',
            'BACHILLERES OFICIAL', 'DEPARTAMENTO NORMALES', 'EDUCACIÓN ESPECIAL',
            'EDUCACIÓN FÍSICA', 'ENSEÑANZAS MUSICALES', 'ESCUELA DE ENFERMERÍA',
            'ESCUELA SECUENDARIA Y BACHILLERATO ABIERTO', 'ESCUELA SECUNDARIA EXPERIMENTAL',
            'ESCUELA SECUNDARIA Y BACHILLERES DE ARTES Y OFICIOS', 'ESCUELA Y BACHILLERES ALFONSO REYES',
            'ESTEBAN M', 'FORÁNEAS', 'ILLUSTRE', 'JUBILADOS Y PENSIONADOS', 'LOCALES',
            'MANUALES', 'NORMAL', 'NORMAL MANUEL SUÁREZ TRUJILLO', 'PREESCOLAR',
            'PRIMARIA', 'SECUNDARIA', 'SECUNDARIA Y BACHILLERATO',
            'TÉCNICOS DOCENTES ADMINISTRATIVOS', 'TELEBACHILLERATO', 'TELESECUNDARIA',
            'UNIVERSIDAD FEMENINA', 'UNIVERSIDAD PEDAGÓGICA VERACRUZANA'
        ];

        foreach ($niveles as $nivel) {
            DB::table('nivel_delegaciones')->insert([
                'nombre' => $nivel,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Niveles de delegación importados correctamente.');
    }
}
