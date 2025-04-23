<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Material extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

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
