<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paquete_agencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('agencia_id')->constrained('agencias')->onDelete('cascade');
            $table->string('titulo');
            $table->string('subtitulo')->nullable();
            $table->string('destino');
            $table->integer('noches');
            $table->string('regimen');
            $table->boolean('vuelo');
            $table->decimal('precio_desde', 10, 2);
            $table->date('vigencia');
            $table->date('fecha')->nullable();
            $table->boolean('multiples_fechas')->default(false);
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->string('hotel');
            $table->integer('estrellas');
            $table->text('descripcion')->nullable();
            $table->string('pais');
            $table->string('ciudad');
            $table->string('ciudad_iata');
            $table->date('fecha_vigencia_desde');
            $table->date('fecha_vigencia_hasta');
            $table->integer('cant_noches');
            $table->string('tipo_producto');
            $table->json('componentes');
            $table->json('categorias');
            $table->json('hoteles');
            $table->string('tipo_moneda');
            $table->boolean('activo');
            $table->string('imagen_principal')->nullable();
            $table->json('galeria_imagenes')->nullable();
            $table->integer('edad_menores')->nullable();
            $table->string('transporte');
            $table->decimal('descuento', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_agencias');
    }
};
