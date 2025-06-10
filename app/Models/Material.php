<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Material extends Model implements Auditable
{
    // Habilita factories y auditoría automática
    use HasFactory, \OwenIt\Auditing\Auditable;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'etiqueta',
        'descripcion',
        'marca',
        'modelo',
        'numero_serie',
        'caracteristicas',
        'aula_id',  // Clave foránea: relación con un aula
    ];

    // Relación: un material pertenece a un aula
    public function aula()
    {
        return $this->belongsTo(Aula::class);
    }
}
