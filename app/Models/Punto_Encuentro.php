<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
