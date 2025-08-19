<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Promoteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'projet',
        'date_entree_accompagnement'
    ];

    protected $casts = [
        'date_entree_accompagnement' => 'date',
    ];

    public function actions()
    {
        return $this->hasMany(Action::class);
    }

    // Méthode pour obtenir la dernière action
    public function derniereAction()
    {
        return $this->actions()->latest('date_action')->first();
    }

    // Méthode pour savoir si l'entreprise est active
    public function estActif()
    {
        $derniereAction = $this->derniereAction();
        return $derniereAction ? $derniereAction->entreprise_active : null;
    }
}
