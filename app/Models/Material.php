<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'etiqueta',
        'descripcion',
        'marca',
        'modelo',
        'numero_serie',
        'caracteristicas',
        'aula_id',
    ];

    public function aula() {
        return $this->belongsTo(Aula::class);
    }
}
