<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Aula extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['nombre', 'ubicacion', 'descripcion'];

    public function equipos()
    {
        return $this->hasMany(Equipo::class, 'aula_id');
    }

    public function materiales()
    {
        return $this->hasMany(Material::class, 'aula_id');
    }

    public function getAuditLabel(array $attributes = [], array $old = []): string
    {
        return $attributes['nombre']
            ?? $old['nombre']
            ?? $this->nombre
            ?? 'Aula';
    }
}
