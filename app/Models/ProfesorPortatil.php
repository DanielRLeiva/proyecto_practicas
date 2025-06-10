<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProfesorPortatil extends Model implements Auditable
{
    // Habilita factories y auditoría automática
    use HasFactory, \OwenIt\Auditing\Auditable;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'profesor_id',     // Relación con Profesor
        'portatil_id',     // Relación con Portátil
        'fecha_inicio',
        'fecha_fin',
        'comentarios',
    ];

    // Relación inversa: este préstamo pertenece a un profesor
    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    // Relación inversa: este préstamo pertenece a un portátil
    public function portatil()
    {
        return $this->belongsTo(Portatil::class);
    }
}
