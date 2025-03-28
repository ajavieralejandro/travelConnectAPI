<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CiudadesJuliaSeeder extends Seeder {
    public function run() {
        $file = storage_path('app/ciudades2.csv');
        $data = array_map('str_getcsv', file($file));

        array_shift($data); // Eliminar encabezado

        foreach ($data as $row) {
            dump($row); // Imprimir la fila para verificar

            // Si la fila tiene 5 elementos, eliminar el primero (vacío) y reajustar los índices
            if (count($row) === 5 && trim($row[0]) === '') {
                array_shift($row);
            }

            // Asegurar que los índices coincidan con los datos correctos
            $codigo_pais   = isset($row[0]) ? trim($row[0]) : null;
            $nombre_pais   = isset($row[1]) ? trim($row[1]) : null;
            $codigo_ciudad = isset($row[2]) ? trim($row[2]) : null;
            $nombre_ciudad = isset($row[3]) ? trim($row[3]) : null;

            dump("Insertando: Código País: $codigo_pais, Nombre País: $nombre_pais, Código Ciudad: $codigo_ciudad, Nombre Ciudad: $nombre_ciudad");

            DB::table('ciudadesJulia')->insert([
                'codigo_pais'   => $codigo_pais,
                'nombre_pais'   => $nombre_pais,
                'codigo_ciudad' => $codigo_ciudad,
                'nombre_ciudad' => $nombre_ciudad,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
