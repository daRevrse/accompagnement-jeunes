<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promoteur extends Model
{
    //
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'projet',
        'date_entree_accompagnement'
        // tous les autres champs de ton formulaire
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function actions()
    {
        return $this->hasMany(Action::class);
    }
}
