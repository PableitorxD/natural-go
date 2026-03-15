<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'cliente_id', 
        'producto_id', 
        'almacen_id', 
        'cantidad', 
        'total', 
        'estado',
        'metodo_pago',
        ];

    // HEMOS ELIMINADO EL MÉTODO BOOT DE AQUÍ PARA NO DUPLICAR
    
    public function cliente() 
    { 
        return $this->belongsTo(Cliente::class); 
    }

    public function producto() 
    { 
        return $this->belongsTo(Producto::class); 
    }

    public function almacen() 
    { 
        return $this->belongsTo(Almacen::class); 
    }
}