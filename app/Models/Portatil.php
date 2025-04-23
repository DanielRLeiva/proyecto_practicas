<?php

namespace App\Models;

use Carbon\Traits\LocalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Portatil extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = ['marca_modelo', 'comentarios'];

    public function usufructo()
    {
        return $this->hasOne(ProfesorPortatil::class);
    }

    /**
     * Método para obtener estados de un portátil
     */
    public function getEstadoAttribute()
    {
        $usufructoActivo = $this->usufructo()->whereNull('fecha_fin')->exists();

        if ($this->activo && !$usufructoActivo) {
            return 'libre';
        } elseif (!$this->activo && $usufructoActivo) {
            return 'en_uso';
        } else {
            return 'inactivo';
        }
    }
}
