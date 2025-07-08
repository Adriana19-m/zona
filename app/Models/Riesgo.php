<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Riesgo extends Model
{
    use HasFactory;


    protected $fillable = [
        'nombre',
        'descripcion',
        'nivel',
        'latitud1', 'longitud1',
        'latitud2', 'longitud2',
        'latitud3', 'longitud3',
        'latitud4', 'longitud4',
    ];
}
