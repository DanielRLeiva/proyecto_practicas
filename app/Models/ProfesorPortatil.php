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
}
