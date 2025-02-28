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
            $table->date('fecha_modificacion');
            $table->string('usuario');
            $table->unsignedBigInteger('usuario_id');
            $table->string('pais');
            $table->string('ciudad');
            $table->string('ciudad_iata');
            $table->date('fecha_vigencia_desde');
            $table->date('fecha_vigencia_hasta');

            $table->integer('cant_noches');
            $table->string('tipo_producto');
            $table->json('componentes');
            $table->json('categorias');
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

    public function down(): void
    {
        Schema::dropIfExists('paquetes');
    }
};
