<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Equipo extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

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

    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }

    public function getAuditLabel(array $attributes = [], array $old = []): string
    {
        return $attributes['etiqueta_cpu']
            ?? $old['etiqueta_cpu']
            ?? $this->etiqueta_cpu
            ?? 'Equipo';
    }
}
