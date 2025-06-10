<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Aula extends Model implements Auditable
{
    // Incluye funcionalidades para fábricas y auditoría automática
    use HasFactory, \OwenIt\Auditing\Auditable;

    // Campos que se pueden asignar masivamente (fillable)
    protected $fillable = ['nombre', 'ubicacion', 'descripcion'];

    /**
     * Relación 1:N con Equipo
     * Un aula puede tener muchos equipos asociados
     */
    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'aula_id');
    }

    /**
     * Relación 1:N con Material
     * Un aula puede tener muchos materiales asociados
     */
    public function materiales()
    {
        return $this->hasMany(Material::class, 'aula_id');
    }
}
