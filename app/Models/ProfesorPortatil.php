<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorPortatil extends Model
{
    use HasFactory;

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
