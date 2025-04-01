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
            Schema::create('destinos_ola', function (Blueprint $table) {
                $table->id();
                $table->string('nombre_pais');
                $table->string('codigo_iata');
                $table->string('codigo_pais');
                $table->string('nombre_ciudad');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinos_ola');
    }
};
