<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class ZonasRiesgo extends Model
{
    //c
    use HasFactory;
    protected $fillable=[
        'nombre',
        'descripcion',
        'nivelRiego',
        'latitud', 'longitud',
    ];
}
