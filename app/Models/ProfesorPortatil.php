<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProfesorPortatil extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'profesor_id',
        'portatil_id',
        'fecha_inicio',
        'fecha_fin',
        'comentarios',
    ];

    public function profesor()
    {
        return $this->belongsTo(Profesor::class);
    }

    public function portatil()
    {
        return $this->belongsTo(Portatil::class);
    }

    public function getAuditLabel(array $attributes = [], array $old = []): string
    {
        $profesorId = $attributes['profesor_id'] ?? $old['profesor_id'] ?? $this->profesor_id;
        $profesor = \App\Models\Profesor::find($profesorId);

        $nombreProfesor = $profesor
            ? trim("{$profesor->nombre} {$profesor->apellido_1} {$profesor->apellido_2}")
            : '';

        $fechaRaw = $attributes['fecha_inicio'] ?? $old['fecha_inicio'] ?? $this->fecha_inicio;
        $fechaInicio = $fechaRaw ? \Carbon\Carbon::parse($fechaRaw)->format('d/m/Y') : '';

        return $nombreProfesor
            ? "Usufructo de $nombreProfesor (Inicio: $fechaInicio)"
            : "Usufructo ($fechaInicio)";
    }
}
