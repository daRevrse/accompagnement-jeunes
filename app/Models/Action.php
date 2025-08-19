<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{

  protected $fillable = [
    'promoteur_id',
    'date_action',
    'chiffre_affaires',
    'entreprise_active',
    'raison_inactivite',
    'arret_activite',
    'investissements',
    'charge',
    'nombre_emplois',
    'situation_credit',
    'difficultes',
    'solutions',
    'action_faiej',
    'date_echeance_action',
    'observations',
    'perspectives',
    'commentaire',
    'actions_prevues',
    'delais',
    'type_suivi',
    'created_by'
];


        // tous les autres champs de ton formulaire


    //
    public function promoteur()
    {
        return $this->belongsTo(Promoteur::class);
    }

    public function rh()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
