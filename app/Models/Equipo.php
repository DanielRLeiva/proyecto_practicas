<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Equipo extends Model implements Auditable
{
    // Incluye funcionalidad para factories y auditoría automática
    use HasFactory, \OwenIt\Auditing\Auditable;

    // Define los campos que se pueden asignar masivamente
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
        'aula_id',           // Clave foránea a Aula
        'numero_inventario',
    ];

    /**
     * Relación inversa con Aula
     * Un equipo pertenece a un aula específica
     */
    public function aula() {
        return $this->belongsTo(Aula::class);
    }
}
