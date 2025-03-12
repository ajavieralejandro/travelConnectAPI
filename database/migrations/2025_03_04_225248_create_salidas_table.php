<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('salidas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paquete_id');
            $table->string('salida_externo_id')->unique()   ;
            $table->boolean('venta_online');
            $table->integer('cupos');
            $table->date('fecha_viaje')->nullable();

            $table->date('fecha_desde')->nullable();
            $table->date('fecha_hasta')->nullable();
            $table->boolean('info_tramos')->default(false);
            // Información de ida
            $table->date('ida_origen_fecha')->nullable();
            $table->time('ida_origen_hora')->nullable();
            $table->string('ida_origen_ciudad')->nullable();
            $table->date('ida_destino_fecha')->nullable();
            $table->time('ida_destino_hora')->nullable();
            $table->string('ida_destino_ciudad')->nullable();
            $table->string('ida_clase_vuelo')->nullable();
            $table->string('ida_linea_aerea')->nullable();
            $table->string('ida_vuelo')->nullable();
            $table->string('ida_escalas')->nullable();

            // Información de vuelta
            $table->date('vuelta_origen_fecha')->nullable();
            $table->time('vuelta_origen_hora')->nullable();
            $table->string('vuelta_origen_ciudad')->nullable();
            $table->date('vuelta_destino_fecha')->nullable();
            $table->time('vuelta_destino_hora')->nullable();
            $table->string('vuelta_destino_ciudad')->nullable();
            $table->string('vuelta_clase_vuelo')->nullable();
            $table->string('vuelta_linea_aerea')->nullable();
            $table->string('vuelta_vuelo')->nullable();
            $table->string('vuelta_escalas')->nullable();

            // Precios y costos
            $table->decimal('single_precio', 10, 2)->nullable();
            $table->decimal('single_impuesto', 10, 2)->nullable();
            $table->decimal('single_otro', 10, 2)->nullable();
            $table->decimal('single_otro2', 10, 2)->nullable();
            $table->decimal('doble_precio', 10, 2)->nullable();
            $table->decimal('doble_impuesto', 10, 2)->nullable();
            $table->decimal('doble_otro', 10, 2)->nullable();
            $table->decimal('doble_otro2', 10, 2)->nullable();
            $table->decimal('triple_precio', 10, 2)->nullable();
            $table->decimal('triple_impuesto', 10, 2)->nullable();
            $table->decimal('triple_otro', 10, 2)->nullable();
            $table->decimal('triple_otro2', 10, 2)->nullable();
            $table->decimal('cuadruple_precio', 10, 2)->nullable();
            $table->decimal('cuadruple_impuesto', 10, 2)->nullable();
            $table->decimal('cuadruple_otro', 10, 2)->nullable();
            $table->decimal('cuadruple_otro2', 10, 2)->nullable();

            // Precios familiares
            $table->decimal('familia_1_precio', 10, 2)->nullable();
            $table->decimal('familia_1_impuesto', 10, 2)->nullable();
            $table->decimal('familia_1_otro', 10, 2)->nullable();
            $table->decimal('familia_1_otro2', 10, 2)->nullable();
            $table->decimal('familia_2_precio', 10, 2)->nullable();
            $table->decimal('familia_2_impuesto', 10, 2)->nullable();
            $table->decimal('familia_2_otro', 10, 2)->nullable();
            $table->decimal('familia_2_otro2', 10, 2)->nullable();

            $table->timestamps();

            // Clave foránea
            $table->foreign('paquete_id')->references('id')->on('paquetes')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salidas');
    }
};
