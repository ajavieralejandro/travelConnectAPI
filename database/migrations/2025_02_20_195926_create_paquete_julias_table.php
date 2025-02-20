<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // En el archivo de migración recién creado
public function up()
{
    Schema::create('paquetes_julia', function (Blueprint $table) {
        $table->id();
        $table->string('paquete_externo_id')->unique();
        $table->string('nombre');
        $table->string('id_destino');
        $table->date('fecha_vigencia_desde');
        $table->date('fecha_vigencia_hasta');
        $table->date('fecha_modificacion');
        $table->integer('cant_noches');
        $table->string('tipo_producto');
        $table->string('tipo_moneda', 3);
        $table->boolean('activo')->default(true);
        $table->string('pais', 2);
        $table->string('ciudad');
        $table->string('ciudad_iata', 3);
        $table->json('componentes')->nullable();
        $table->json('categorias')->nullable();
        $table->string('transporte')->nullable();
        $table->decimal('descuento', 5, 2)->default(0.00);
        $table->string('imagen_principal')->nullable();
        $table->json('galeria_imagenes')->nullable();
        $table->string('usuario');
        $table->unsignedBigInteger('usuario_id');
        $table->integer('edad_menores')->nullable();
        $table->timestamps();

        $table->index('pais');
        $table->index('ciudad');
        $table->index('fecha_vigencia_desde');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paquete_julias');
    }
};
