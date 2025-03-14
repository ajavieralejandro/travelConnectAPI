<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
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
            $table->string('color_principal');
            $table->string('color_secundario');
            $table->string('color_barra_superior');
            $table->boolean('filtro_imagen_1');
            $table->boolean('filtro_imagen_2');
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('nombre_de_contacto');
            $table->string('direccion');
            $table->string('whatsapp');
            $table->string('mail');
            $table->string('telefono');
            $table->text('info_contacto_es')->nullable();
            $table->text('info_contacto_en')->nullable();
            $table->text('info_contacto_pt')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agencias');
    }
};
