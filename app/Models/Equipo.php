<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $fillable = [
        'etiqueta_cpu',
        'marca_cpu',
        'modelo_cpu',
        'numero_serie_cpu',
        'tipo_cpu',
        'memoria',
        'disco_duro',
        'conectores_video',
        'etiqueta_monitor',
        'marca_monitor',
        'modelo_monitor',
        'conectores_monitor',
        'pulgadas',
        'numero_serie_monitor',
        'etiqueta_teclado',
        'etiqueta_raton',
        'observaciones',
        'aula_id',
    ];

    public function aula() {
        return $this->belongsTo(Aula::class);
    }
}
