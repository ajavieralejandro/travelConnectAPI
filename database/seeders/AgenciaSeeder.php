<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Tenant; // Asegúrate de importar el modelo Tenant si existe

class AgenciaSeeder extends Seeder
{
    public function run()
    {
        // Datos de la agencia
        $agenciaData = [
            'tenant_id' => 1,  // Este será actualizado después de crear el tenant
            'estado' => true,
            'nombre' => 'Océano Profundo',
            'password' => bcrypt('password123'),
            'dominio' => 'oceanoprofundo',
            'quienes_somos_es' => 'Acerca de nosotros en español...',
            'quienes_somos_en' => 'About us in English...',
            'quienes_somos_pt' => 'Sobre nós em português...',
            'favicon' => '/favicon.ico',
            'logo' => '/logo1.png',
            'fondo_1' => '/fondo1.jpg',
            'fondo_2' => '/fondo2.jpg',
            'color_principal' => '#1E88E5',
            'color_secundario' => '#90CAF9',
            'color_barra_superior' => '#1565C0',
            'filtro_imagen_1' => false,
            'filtro_imagen_2' => false,

            // Datos Generales
            'tipografia_agencia' => 'Poppins',
            'color_tipografia_agencia' => '#FFFFFF',
            'color_fondo_app' => '#F5F5F5',
            'color_primario' => '#1E88E5',
            'color_secundario' => '#90CAF9',
            'color_terciario' => '#1565C0',

            // Header
            'header_imagen_background' => '/montania.jpg',
            'header_imagen_background_opacidad' => 0.8,
            'header_video_background' => null,
            'header_video_background_opacidad' => null,

            // Buscador
            'buscador_tipografia' => 'Poppins',
            'buscador_tipografia_color' => '#FFFFFF',
            'buscador_tipografia_color_label' => '#90CAF9',
            'buscador_color_primario' => '#1E88E5',
            'buscador_color_secundario' => '#90CAF9',
            'buscador_color_terciario' => '#1565C0',

            // Publicidad Cliente
            'publicidad_existe' => true,
            'publicidad_titulo' => 'Explora el océano',
            'publicidad_tipografia_color' => '#FFFFFF',
            'publicidad_color_primario' => '#1E88E5',
            'publicidad_color_secundario' => '#90CAF9',
            'publicidad_color_terciario' => '#1565C0',
            'publicidad_imagen_1' => '/desierto.jpg',
            'publicidad_imagen_2' => '/montania.jpg',
            'publicidad_imagen_3' => '/jungla.jpg',

            // Tarjetas
            'tarjetas_titulo' => 'Destacados marinos',
            'tarjetas_tipografia' => 'Poppins',
            'tarjetas_tipografia_color' => '#333333',
            'tarjetas_tipografia_color_titulo' => '#FFFFFF',
            'tarjetas_tipografia_color_contenido' => '#000000',
            'tarjetas_color_primario' => '#1E88E5',
            'tarjetas_color_secundario' => '#90CAF9',
            'tarjetas_color_terciario' => '#1565C0',

            // Banner de Registro
            'banner_registro_titulo' => '¡Regístrate y explora!',
            'banner_registro_tipografia_color' => '#FFFFFF',
            'banner_registro_color_primario' => '#1E88E5',
            'banner_registro_color_secundario' => '#90CAF9',
            'banner_registro_color_terciario' => '#1565C0',

            // Footer
            'footer_texto' => '© 2025 Océano Profundo. Todos los derechos reservados.',
            'footer_tipografia' => 'Poppins',
            'footer_tipografia_color' => '#FFFFFF',
            'footer_color_primario' => '#1565C0',
            'footer_color_secundario' => '#90CAF9',
            'footer_color_terciario' => '#1E88E5',
            'footer_facebook' => 'https://facebook.com',
            'footer_twitter' => 'https://twitter.com',
            'footer_instagram' => 'https://instagram.com',
            'footer_whatsapp' => 'https://wa.me',
            'footer_telefono' => '+123456789',
            'footer_email' => 'info@oceanoprofundo.com',
            'footer_direccion' => 'Calle Mar 123',
            'footer_ciudad' => 'Mar Azul',
            'footer_pais' => 'Argentina',

            'created_at' => now(),
            'updated_at' => now(),
        ];

        // Crear el tenant primero
        $tenant = Tenant::create([
            'subdomain' => $agenciaData['dominio'],
            'template' => null,
            'data' => json_encode([
                'nombre' => $agenciaData['nombre'],
                'dominio' => $agenciaData['dominio'],
                'configuraciones' => [
                    'colores' => [
                        'principal' => $agenciaData['color_principal'],
                        'secundario' => $agenciaData['color_secundario'],
                    ],
                    'tipografia' => $agenciaData['tipografia_agencia'],
                ]
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Actualizar el tenant_id en los datos de la agencia
        $agenciaData['tenant_id'] = $tenant->id;

        // Insertar los datos de la agencia
        DB::table('agencias')->insert($agenciaData);

        // Crear la carpeta en el storage
        $carpetaAgencia = 'agencias/' . $agenciaData['dominio'];
        Storage::disk('local')->makeDirectory($carpetaAgencia);
        Storage::disk('local')->makeDirectory($carpetaAgencia . '/imagenes');
        Storage::disk('local')->makeDirectory($carpetaAgencia . '/documentos');
        Storage::disk('local')->makeDirectory($carpetaAgencia . '/logos');


        $this->command->info("Agencia '{$agenciaData['nombre']}' creada con éxito.");
        $this->command->info("Tenant creado con ID: {$tenant->id} y subdominio: {$tenant->subdomain}");
        $this->command->info("Carpeta creada en: storage/app/{$carpetaAgencia}");
    }
}