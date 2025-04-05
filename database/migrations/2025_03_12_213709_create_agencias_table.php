<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {

        /**
         *
                // === Datos Principales ===


                // === Datos Generales ===

                // === Header ===


                // === Buscador ===


                // === Publicidad Cliente ===



                // === Tarjetas ===







         */
        Schema::create('agencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');
            $table->boolean('estado');
            $table->string('nombre');
            $table->string('password');
            $table->string('dominio');
            $table->text('quienes_somos_es')->nullable();
            $table->text('quienes_somos_en')->nullable();
            $table->text('quienes_somos_pt')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('fondo_1')->nullable();
            $table->string('fondo_2')->nullable();
            $table->string('color_principal')->nullable();
            $table->string('color_barra_superior')->nullable();
            $table->boolean('filtro_imagen_1')->nullable();
            $table->boolean('filtro_imagen_2')->nullable();

            // Datos Generales
            $table->string('tipografia_agencia')->nullable();
            $table->string('color_tipografia_agencia')->nullable();
            $table->string('color_fondo_app')->nullable();
            $table->string('color_primario')->nullable();
            $table->string('color_secundario')->nullable();
            $table->string('color_terciario')->nullable();

            // Header
            $table->string('header_imagen_background')->nullable();
            $table->decimal('header_imagen_background_opacidad', 5, 2)->nullable();
            $table->string('header_video_background')->nullable();
            $table->decimal('header_video_background_opacidad', 5, 2)->nullable();

            // Buscador
            $table->string('buscador_tipografia')->nullable();
            $table->string('buscador_tipografia_color')->nullable();
            $table->string('buscador_tipografia_color_label')->nullable();
            $table->string('buscador_color_primario')->nullable();
            $table->string('buscador_color_secundario')->nullable();
            $table->string('buscador_color_terciario')->nullable();
            $table->string('buscador_inputFondoColor')->nullable();

            // Publicidad Cliente
            $table->boolean('publicidad_existe');
            $table->string('publicidad_titulo')->nullable();
            $table->string('publicidad_tipografia_color')->nullable();
            $table->string('publicidad_color_primario')->nullable();
            $table->string('publicidad_color_secundario')->nullable();
            $table->string('publicidad_color_terciario')->nullable();
            $table->string('publicidad_imagen_1')->nullable();
            $table->string('publicidad_imagen_2')->nullable();
            $table->string('publicidad_imagen_3')->nullable();

            // Tarjetas
            $table->string('tarjetas_titulo')->nullable();
            $table->string('tarjetas_tipografia')->nullable();
            $table->string('tarjetas_tipografia_color')->nullable();
            $table->string('tarjetas_tipografia_color_titulo')->nullable();
            $table->string('tarjetas_tipografia_color_contenido')->nullable();
            $table->string('tarjetas_color_primario')->nullable();
            $table->string('tarjetas_color_secundario')->nullable();
            $table->string('tarjetas_color_terciario')->nullable();

            // Banner de Registro
            $table->string('banner_registro_titulo')->nullable();
            $table->string('banner_registro_tipografia_color')->nullable();
            $table->string('banner_registro_color_primario')->nullable();
            $table->string('banner_registro_color_secundario')->nullable();
            $table->string('banner_registro_color_terciario')->nullable();

            // Footer
            $table->string('footer_texto')->nullable();
            $table->string('footer_tipografia')->nullable();
            $table->string('footer_tipografia_color')->nullable();
            $table->string('footer_color_primario')->nullable();
            $table->string('footer_color_secundario')->nullable();
            $table->string('footer_color_terciario')->nullable();
            $table->string('footer_facebook')->nullable();
            $table->string('footer_twitter')->nullable();
            $table->string('footer_instagram')->nullable();
            $table->string('footer_whatsapp')->nullable();
            $table->string('footer_telefono')->nullable();
            $table->string('footer_email')->nullable();
            $table->string('footer_direccion')->nullable();
            $table->string('footer_ciudad')->nullable();
            $table->string('footer_pais')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agencias');
    }
};
