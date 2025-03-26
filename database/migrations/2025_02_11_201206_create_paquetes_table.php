<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paquetes', function (Blueprint $table) {
            $table->id();
            $table->string('paquete_externo_id')->unique();
            $table->date('fecha_modificacion')->nullable();
            $table->string('usuario')->nullable();
            $table->unsignedBigInteger('usuario_id')->nullable();
            $table->string('pais')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('ciudad_iata')->nullable();
            $table->date('fecha_vigencia_desde')->nullable();
            $table->date('fecha_vigencia_hasta')->nullable();
            $table->string('titulo')->nullable();
            $table->integer('cant_noches')->nullable();
            $table->string('tipo_producto')->nullable();
            $table->json('componentes')->nullable();
            $table->json('categorias')->nullable();
            $table->string('tipo_moneda')->nullable();
            $table->boolean('activo')->nullable();
            $table->string('imagen_principal')->nullable();
            $table->json('galeria_imagenes')->nullable();
            $table->integer('edad_menores')->nullable();
            $table->string('transporte')->nullable();
            $table->json('hoteles')->nullable();
            $table->string('descripcion')->nullable();
            $table->decimal('descuento', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
