<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api extends Model
{
    //
    protected $fillable = ['nombre', 'descripcion','endpoint'];

    public function agencias()
    {
        return $this->belongsToMany(Agencia::class, 'agencia_api');
    }
}
