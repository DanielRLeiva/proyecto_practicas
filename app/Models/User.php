<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, \OwenIt\Auditing\Auditable;
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAuditLabel(array $attributes = [], array $old = []): string
    {
        $userName = $this->name ?? 'Usuario';

        if (isset($old['roles'])) {
            $oldRole = is_array($old['roles']) ? implode(', ', $old['roles']) : $old['roles'];
            $newRole = is_array($attributes['roles']) ? implode(', ', $attributes['roles']) : $attributes['roles'];

            return $oldRole === $newRole
                ? "Rol asignado a $userName: $newRole"
                : "Rol cambiado para $userName: $oldRole → $newRole";
        }

        return "Nuevo usuario creado: $userName";
    }
}
