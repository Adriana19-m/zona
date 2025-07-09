<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seguras extends Model
{
    //
     use HasFactory;
    protected $fillable = [
        'nombre',
        'radio',
        'tipo',
        'latitud',
        'longitud',
    ];
}
