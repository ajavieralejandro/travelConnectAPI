<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrigenJuliaSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            ['A', 'SANTA ROSA'],
            ['B', 'BUENOS AIRES'],
            ['C', 'CORRIENTES'],
            ['D', 'IGUAZU'],
            ['E', 'NEUQUEN'],
            ['F', 'SAN RAFAEL'],
            ['G', 'RIO GRANDE'],
            ['H', 'BAHIA BLANCA'],
            ['I', 'BARILOCHE'],
            ['J', 'JUJUY'],
            ['K', 'SAN JUAN'],
            ['L', 'SAN LUIS'],
            ['M', 'MAR DEL PLATA'],
            ['N', 'ASUNCION'],
            ['O', 'CORDOBA'],
            ['P', 'POSADAS'],
            ['Q', 'COMODORO RIVADAVIA'],
            ['R', 'ROSARIO'],
            ['S', 'SALTA'],
            ['T', 'TUCUMAN'],
            ['U', 'USHUAIA'],
            ['V', 'RIO GALLEGOS'],
            ['X', 'VIEDMA'],
            ['Y', 'FORMOSA'],
            ['Z', 'MENDOZA'],
            ['0', 'RESISTENCIA'],
            ['1', 'SANTIAGO DEL ESTERO'],
            ['2', 'ESQUEL'],
            ['3', 'TRELEW'],
            ['4', 'EL CALAFATE'],
            ['5', 'CATAMARCA'],
            ['6', 'LA RIOJA'],
            ['7', 'SANTA FE'],
        ];

        $data = array_map(function ($entry) {
            return [
                'codigo' => $entry[0],
                'ciudad' => trim($entry[1]),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }, $entries);

        DB::table('origenJulia')->insert($data);
    }
}