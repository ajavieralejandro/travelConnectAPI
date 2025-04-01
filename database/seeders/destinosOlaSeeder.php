<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinosOlaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $destinos = [
            [
                'nombre_pais' => 'Argentina',
                'codigo_iata' => 'SLA',
                'codigo_pais' => 'AR',
                'nombre_ciudad' => 'Salta',
            ],
            [
                'nombre_pais' => 'Aruba',
                'codigo_iata' => 'AUA',
                'codigo_pais' => 'AH',
                'nombre_ciudad' => 'Aruba',
            ],
            [
                'nombre_pais' => 'Cuba',
                'codigo_iata' => 'CDG',
                'codigo_pais' => 'CU',
                'nombre_ciudad' => 'Cayo Coco-Cayo Guillermo',
            ],
            [

                'nombre_pais' => 'Cuba',
                'codigo_iata' => 'NHC',
                'codigo_pais' => 'CU',
                'nombre_ciudad' => 'Cayo Ensenchados',
            ],
            [

                'nombre_pais' => 'Cuba',
                'codigo_iata' => 'CST',
                'codigo_pais' => 'CU',
                'nombre_ciudad' => 'Cayo Santa Maria',
            ],
            [
                'nombre_pais' => 'Cuba',
                'codigo_iata' => 'HAV',
                'codigo_pais' => 'CU',
                'nombre_ciudad' => 'La Habana',
            ],
            [
                'nombre_pais' => 'Cuba',
                'codigo_iata' => 'VRA',
                'codigo_pais' => 'CU',
                'nombre_ciudad' => 'Varadero',
            ],
            [
                'nombre_pais' => 'México',
                'codigo_iata' => 'CUN',
                'codigo_pais' => 'MX',
                'nombre_ciudad' => 'Cancún',
            ],
            [
                'nombre_pais' => 'México',
                'codigo_iata' => 'CSM',
                'codigo_pais' => 'MX',
                'nombre_ciudad' => 'Costa de Mujeres',
            ],
            ['nombre_pais' => 'México',
                'codigo_iata' => 'PCA',
                'codigo_pais' => 'MX',
                'nombre_ciudad' => 'Playa del Carmen',
            ],
            [
               'nombre_pais' => 'México',
                'codigo_iata' => 'PLA',
                'codigo_pais' => 'MX',
                'nombre_ciudad' => 'Playa mujeres',
            ],
            [
                'nombre_pais' => 'México',
                 'codigo_iata' => 'AKU',
                 'codigo_pais' => 'MX',
                 'nombre_ciudad' => 'Rivera Maya - Akumal',
             ],
             [
                'nombre_pais' => 'México',
                 'codigo_iata' => 'PYP',
                 'codigo_pais' => 'MX',
                 'nombre_ciudad' => 'Rivera Maya - Playa Paradiso',
             ],
             [
                'nombre_pais' => 'México',
                 'codigo_iata' => 'MOR',
                 'codigo_pais' => 'MX',
                 'nombre_ciudad' => 'Rivera Maya - Puerto Morelos',
             ],
             [
                'nombre_pais' => 'México',
                 'codigo_iata' => 'TUY',
                 'codigo_pais' => 'MX',
                 'nombre_ciudad' => 'Rivera Maya - Tulum',
             ],
             [
                'nombre_pais' => 'México',
                 'codigo_iata' => 'PAV',
                 'codigo_pais' => 'MX',
                 'nombre_ciudad' => 'Rivera Maya - Puerto Aventuras',
             ],
             [
                'nombre_pais' => 'Republica Dominicana',
                 'codigo_iata' => 'MIC',
                 'codigo_pais' => 'RD',
                 'nombre_ciudad' => 'Miches',
             ],
             [
                'nombre_pais' => 'Republica Dominicana',
                 'codigo_iata' => 'LRM',
                 'codigo_pais' => 'RD',
                 'nombre_ciudad' => 'La Romana ',
             ],
             [
                'nombre_pais' => 'Republica Dominicana',
                 'codigo_iata' => 'PUJ',
                 'codigo_pais' => 'RD',
                 'nombre_ciudad' => 'Punta Cana ',
             ],
             [
                'nombre_pais' => 'Republica Dominicana',
                 'codigo_iata' => 'AZS',
                 'codigo_pais' => 'RD',
                 'nombre_ciudad' => 'Samana',
             ],
        ];

        // Fix any typos in field names before insertion
        $correctedDestinos = array_map(function($item) {
            return [
                'nombre_pais' => $item['nombre_pais'] ?? $item['nombre_pais'] ?? '',
                'codigo_iata' => $item['codigo_iata'],
                'codigo_pais' => $item['codigo_pais'] ?? $item['codigo_pais'] ?? '',
                'nombre_ciudad' => $item['nombre_ciudad'],
            ];
        }, $destinos);

        DB::table('destinos_ola')->insert($correctedDestinos);
    }
}