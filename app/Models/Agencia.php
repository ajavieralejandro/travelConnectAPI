<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Agencia extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'tenant_id', 'estado', 'nombre', 'password', 'dominio',
        'quienes_somos_es', 'quienes_somos_en', 'quienes_somos_pt',
        'favicon', 'logo', 'fondo_1', 'fondo_2',
        'color_principal', 'color_secundario', 'color_barra_superior',
        'filtro_imagen_1', 'filtro_imagen_2',
        'facebook', 'instagram', 'twitter', 'youtube', 'linkedin',
        'nombre_de_contacto', 'direccion', 'whatsapp', 'mail', 'telefono',
        'info_contacto_es', 'info_contacto_en', 'info_contacto_pt'
    ];

    protected $hidden = ['password'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
    public function apis()
    {
        return $this->belongsToMany(Api::class, 'agencia_api');
    }
}
