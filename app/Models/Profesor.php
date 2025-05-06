<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Profesor extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['nombre', 'apellido_1', 'apellido_2'];

    public function usufructo()
    {
        return $this->hasMany(ProfesorPortatil::class);
    }

    public function getAuditLabel(array $attributes = [], array $old = []): string
    {
        $nombre = $attributes['nombre'] ?? $old['nombre'] ?? $this->nombre ?? '';
        $apellido1 = $attributes['apellido_1'] ?? $old['apellido_1'] ?? $this->apellido_1 ?? '';
        $apellido2 = $attributes['apellido_2'] ?? $old['apellido_2'] ?? $this->apellido_2 ?? '';

        return trim("$nombre $apellido1 $apellido2");
    }
}
