<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profesor extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'apellido_1', 'apellido_2'];

    public function usufructo()
    {
       return $this->hasMany(ProfesorPortatil::class);
    }
}
