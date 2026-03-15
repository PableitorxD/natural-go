<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    // Definimos la tabla correctamente para evitar el error 'almacens'
    protected $table = 'almacenes';

    protected $fillable = ['nombre', 'ubicacion'];

    /**
     * Relación: Un almacén tiene muchos registros de inventario (entradas y salidas).
     * Esta es la relación que usamos en AlmacenController para calcular el stock real.
     */
    public function inventarios()
    {
        return $this->hasMany(Inventario::class, 'almacen_id');
    }

    /**
     * Opcional: Si quieres obtener los productos directamente a través del inventario.
     */
    public function productos()
    {
        return $this->hasManyThrough(
            Producto::class, 
            Inventario::class, 
            'almacen_id', // Llave foránea en inventarios
            'id',         // Llave primaria en productos
            'id',         // Llave primaria en almacenes
            'producto_id' // Llave foránea en inventarios
        );
    }
}