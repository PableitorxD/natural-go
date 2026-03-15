<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
    protected $fillable = ['nombre', 'descripcion', 'precio', 'precio_costo', 'stock', 'imagen', 'categoria_id'];

    // Esto hace que stock_real aparezca siempre en los resultados JSON/Arrays
    protected $appends = ['stock_real'];

    public function categoria() 
    {
        return $this->belongsTo(Categoria::class);
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    /**
     * Calcula la suma total de stock sumando todos los almacenes.
     * Uso: $producto->stock_real
     */
    public function getStockRealAttribute()
    {
        return $this->inventarios()->sum('cantidad');
    }
}