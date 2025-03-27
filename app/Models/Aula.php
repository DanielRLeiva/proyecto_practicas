<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'ubicacion', 'descripcion'];

    public function equipos() {
        return $this->hasMany(Equipo::class, 'aula_id');
    }

    public function materiales() {
        return $this->hasMany(Material::class, 'aula_id');
    }
}
