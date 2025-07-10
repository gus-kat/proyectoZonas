<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punto_Encuentro extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'capacidad',
        'responsable',
        'imagen',
        'latitud',
        'longitud',
    ];
}
