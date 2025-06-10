<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Profesor extends Model implements Auditable
{
    // Habilita factories y auditoría automática
    use HasFactory, \OwenIt\Auditing\Auditable;

    // Campos que se pueden asignar masivamente
    protected $fillable = ['nombre', 'apellido_1', 'apellido_2'];

    // Relación: un profesor puede tener varios usufructos de portátiles
    public function usufructo()
    {
        return $this->hasMany(ProfesorPortatil::class);
    }
}
