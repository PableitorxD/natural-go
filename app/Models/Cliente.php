<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
    'nombre', 'apellido', 'ci', 'telefono', 'email', 'direccion', 'fecha_nacimiento'
];
}
