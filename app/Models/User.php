<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // MANQUANT dans votre fillable !
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Méthodes de rôle
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isRH()
    {
        return $this->role === 'rh';
    }

    public function isPromoteur()
    {
        return $this->role === 'promoteur';
    }

    // Relation avec les actions créées (pour les RH)
    public function actionsCreated()
    {
        return $this->hasMany(Action::class, 'created_by');
    }
}
