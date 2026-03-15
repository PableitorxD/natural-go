<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioNutricional extends Model
{
    use HasFactory;

    protected $table = 'servicios_nutricionales'; // Indicamos el nombre de la tabla

    protected $fillable = [
        'cliente_id', 'fecha_consulta', 'peso', 'talla', 'imc', 
        'porcentaje_grasa', 'porcentaje_musculo', 'cintura', 
        'cadera', 'objetivo', 'plan_sugerido', 'observaciones'
    ];

    // Relación: Una consulta pertenece a un cliente
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}