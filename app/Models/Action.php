<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Action extends Model
{
    use HasFactory;

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

    protected $casts = [
        'date_action' => 'date',
        'date_echeance_action' => 'date',
        'entreprise_active' => 'boolean',
        'chiffre_affaires' => 'decimal:2',
        'charge' => 'decimal:2',
        'investissements' => 'decimal:2',
    ];

    public function promoteur()
    {
        return $this->belongsTo(Promoteur::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope pour les entreprises actives
    public function scopeActives($query)
    {
        return $query->where('entreprise_active', true);
    }

    // Scope pour les entreprises inactives
    public function scopeInactives($query)
    {
        return $query->where('entreprise_active', false);
    }
}
