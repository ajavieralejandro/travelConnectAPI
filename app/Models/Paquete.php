<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paquete extends Model
{
    use HasFactory;

    protected $table = 'paquetes';

    protected $fillable = [
        'paquete_externo_id',
        'fecha_modificacion',
        'usuario',
        'usuario_id',
        'pais',
        'ciudad',
        'ciudad_iata',
        'fecha_vigencia_desde',
        'fecha_vigencia_hasta',
        'cant_noches',
        'tipo_producto',
        'componentes',
        'categorias',
        'tipo_moneda',
        'activo',
        'imagen_principal',
        'galeria_imagenes',
        'edad_menores',
        'transporte',
        'descuento',
    ];

    protected $casts = [
        'fecha_modificacion' => 'date',
        'fecha_vigencia_desde' => 'date',
        'fecha_vigencia_hasta' => 'date',
        'activo' => 'boolean',
        'componentes' => 'array',
        'categorias' => 'array',
        'galeria_imagenes' => 'array',
    ];

    public function salidas()
{
    return $this->hasMany(Salida::class);
}
}
