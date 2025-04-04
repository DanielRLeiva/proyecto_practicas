<?php

namespace App\Models;

use Carbon\Traits\LocalFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portatil extends Model
{
    use HasFactory;

    protected $fillable = ['marca_modelo', 'comentarios'];

    public function usufructo()
    {
    return $this->hasOne(ProfesorPortatil::class);
    } 
}
