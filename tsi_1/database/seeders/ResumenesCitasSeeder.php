<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResumenesCitasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('resumenes_citas')->insert([
            [
                'idCita'       => 1,
                'diagnostico'  => 'Hipertensión controlada',
                'prescripcion' => 'Losartán 50mg diario',
                'numReceta'    => 1001,
            ],
            [
                'idCita'       => 2,
                'diagnostico'  => 'Resfriado común',
                'prescripcion' => 'Paracetamol 500mg cada 8 horas',
                'numReceta'    => 1002,
            ],
        ]);
    }
}
