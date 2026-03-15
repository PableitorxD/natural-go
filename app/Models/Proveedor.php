<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    // Forzamos el nombre de la tabla en español
    protected $table = 'proveedores'; 

    protected $fillable = ['nombre', 'nit', 'telefono', 'direccion', 'contacto_nombre'];
}