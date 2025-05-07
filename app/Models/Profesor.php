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
}
