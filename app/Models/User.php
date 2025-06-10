<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    // Incluye funcionalidades: factories, notificaciones, roles y auditoría
    use HasFactory, Notifiable, HasRoles, \OwenIt\Auditing\Auditable;

    // Campos que pueden asignarse masivamente
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Campos ocultos cuando se serializa el modelo
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Conversión de atributos a tipos nativos
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Aplica hash automáticamente
        ];
    }
}
