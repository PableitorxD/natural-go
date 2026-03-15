<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $fillable = [
        'cliente_id',
        'monto',
        'moneda',
        'estado',
        'referencia_libelula',
        'qr_image'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}