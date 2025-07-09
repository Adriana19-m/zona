<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Encuentro extends Model
{
    //
    use HasFactory;
    protected $fillable=[
        'nombre',
        'capacidad',
        'responsable',
        'latitud',
        'longitud',
    ];
}
