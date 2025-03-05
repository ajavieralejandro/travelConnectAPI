<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    use HasFactory;

    protected $fillable = [
        'paquete_id',
        'salida_externo_id',
        'venta_online',
        'cupos',
        'fecha_desde',
        'fecha_hasta',
        'ida_origen_fecha',
        'ida_origen_hora',
        'ida_origen_ciudad',
        'ida_destino_fecha',
        'ida_destino_hora',
        'ida_destino_ciudad',
        'ida_clase_vuelo',
        'ida_linea_aerea',
        'ida_vuelo',
        'ida_escalas',
        'vuelta_origen_fecha',
        'vuelta_origen_hora',
        'vuelta_origen_ciudad',
        'vuelta_destino_fecha',
        'vuelta_destino_hora',
        'vuelta_destino_ciudad',
        'vuelta_clase_vuelo',
        'vuelta_linea_aerea',
        'vuelta_vuelo',
        'vuelta_escalas',
        'single_precio',
        'single_impuesto',
        'single_otro',
        'single_otro2',
        'doble_precio',
        'doble_impuesto',
        'doble_otro',
        'doble_otro2',
        'triple_precio',
        'triple_impuesto',
        'triple_otro',
        'triple_otro2',
        'cuadruple_precio',
        'cuadruple_impuesto',
        'cuadruple_otro',
        'cuadruple_otro2',
        'familia_1_precio',
        'familia_1_impuesto',
        'familia_1_otro',
        'familia_1_otro2',
        'familia_2_precio',
        'familia_2_impuesto',
        'familia_2_otro',
        'familia_2_otro2',
    ];

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }
}
