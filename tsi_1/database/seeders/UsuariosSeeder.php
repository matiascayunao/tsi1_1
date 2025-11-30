<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'rut' => '11111111-1',
                'nombre' => 'Secretaria Ana',
                'password' => Hash::make('12345678'),
                'rol' => 'secretaria',
            ],
            [
                'rut' => '22222222-2',
                'nombre' => 'Dr. Pérez',
                'password' => Hash::make('12345678'),
                'rol' => 'medico',
            ],
            [
                'rut' => '4',
                'nombre' => ' Dr Test',
                'password' => Hash::make('1'),
                'rol' => 'medico',
            ],


        ]);
    }
}
