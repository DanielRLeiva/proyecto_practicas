<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Portatil extends Model implements Auditable
{
    // Habilita factories y auditoría automática
    use HasFactory, \OwenIt\Auditing\Auditable;

    // Campos asignables masivamente
    protected $fillable = ['marca_modelo', 'comentarios'];

    // Relación: un portátil puede tener un usufructo activo
    public function usufructo()
    {
        return $this->hasOne(ProfesorPortatil::class);
    }
}
