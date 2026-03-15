<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    // Aquí le decimos a Laravel qué columnas puede llenar
    protected $fillable = ['producto_id', 'almacen_id', 'cantidad', 'proveedor'];

    /**
     * El método boot se ejecuta automáticamente. 
     * Aquí indicamos que cuando se CREE un registro de inventario, 
     * se actualice el stock del producto.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($inventario) {
            // Buscamos el producto relacionado y le sumamos la cantidad ingresada
            $producto = $inventario->producto;
            if ($producto) {
                // Si cantidad es 10, suma 10. Si es -5, resta 5.
                $producto->increment('stock', $inventario->cantidad);
            }
        });
    }

    // Relación con el producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    // Relación para que el inventario sepa a qué almacén pertenece
    public function almacen()
    {
        return $this->belongsTo(Almacen::class);
    }
}