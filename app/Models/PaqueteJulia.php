<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteJulia extends Model
{
    use HasFactory;

    protected $table = 'paquetes_julia';

    protected $fillable = [
        'paquete_externo_id',
        'nombre',
        'id_destino',
        'fecha_vigencia_desde',
        'fecha_vigencia_hasta',
        'fecha_modificacion',
        'cant_noches',
        'tipo_producto',
        'tipo_moneda',
        'activo',
        'pais',
        'ciudad',
        'ciudad_iata',
        'componentes',
        'categorias',
        'transporte',
        'descuento',
        'imagen_principal',
        'galeria_imagenes',
        'usuario',
        'usuario_id',
        'edad_menores'
    ];

    protected $casts = [
        'fecha_vigencia_desde' => 'date',
        'fecha_vigencia_hasta' => 'date',
        'fecha_modificacion' => 'date',
        'componentes' => 'array',
        'categorias' => 'array',
        'galeria_imagenes' => 'array',
        'activo' => 'boolean',
        'descuento' => 'decimal:2'
    ];
}
