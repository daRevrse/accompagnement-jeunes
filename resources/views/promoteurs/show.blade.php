@extends('layouts.app')

@section('content')
<div class="container">
    <!-- En-tête avec informations du promoteur -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">👤 {{ $promoteur->nom }}</h1>
            <p class="text-muted mb-0">{{ $promoteur->projet }}</p>
        </div>
        <div>
            <a href="{{ route('promoteurs.edit', $promoteur) }}" class="btn btn-outline-primary me-2">
                ✏️ Modifier
            </a>
            <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-success">
                ➕ Nouvelle action
            </a>
        </div>
    </div>

    <!-- Carte d'informations principales -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📋 Informations générales</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Email :</strong> {{ $promoteur->email }}</p>
                            <p><strong>Téléphone :</strong> {{ $promoteur->telephone }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Projet :</strong> {{ $promoteur->projet }}</p>
                            <p><strong>Accompagnement depuis :</strong>
                                {{ $promoteur->date_entree_accompagnement ? $promoteur->date_entree_accompagnement->format('d/m/Y') : 'Non renseigné' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">📊 Statistiques</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Total actions :</span>
                        <strong>{{ $stats['total_actions'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>CA total :</span>
                        <strong>{{ number_format($stats['ca_total'], 0, ',', ' ') }} FCFA</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>CA moyen :</span>
                        <strong>{{ number_format($stats['ca_moyen'], 0, ',', ' ') }} FCFA</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Statut :</span>
                        @if($stats['entreprise_active'] === true)
                        <span class="badge bg-success">Actif</span>
                        @elseif($stats['entreprise_active'] === false)
                        <span class="badge bg-danger">Inactif</span>
                        @else
                        <span class="badge bg-secondary">Inconnu</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des actions -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📝 Historique des actions ({{ $stats['total_actions'] }})</h5>
            @if($stats['derniere_action'])
            <small class="text-muted">
                Dernière action : {{ $stats['derniere_action']->date_action->format('d/m/Y') }}
            </small>
            @endif
        </div>

        @if($actions->count())
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Type suivi</th>
                        <th class="text-end">CA (FCFA)</th>
                        <th class="text-end">Emplois</th>
                        <th>Créé par</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actions as $action)
                    <tr>
                        <td>
                            <strong>{{ $action->date_action->format('d/m/Y') }}</strong>
                            @if($action->date_echeance_action)
                            <br><small class="text-muted">Échéance: {{ $action->date_echeance_action->format('d/m/Y') }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $action->entreprise_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>{{ $action->type_suivi ?? '-' }}</td>
                        <td class="text-end">
                            {{ $action->chiffre_affaires ? number_format($action->chiffre_affaires, 0, ',', ' ') : '-' }}
                        </td>
                        <td class="text-end">{{ $action->nombre_emplois ?? '-' }}</td>
                        <td>{{ $action->createdBy->name ?? 'Système' }}</td>
                        <td class="text-center">
                            <a href="{{ route('actions.show', $action) }}" class="btn btn-sm btn-outline-info">
                                👁️ Voir
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer">
            {{ $actions->links() }}
        </div>
        @else
        <div class="card-body text-center py-5">
            <div class="text-muted">
                <i class="bi bi-journal-x fs-1 mb-3"></i>
                <h5>Aucune action enregistrée</h5>
                <p>Ce promoteur n'a pas encore d'actions enregistrées.</p>
                <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-primary">
                    ➕ Créer la première action
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Bouton retour -->
    <div class="mt-4">
        <a href="{{ route('promoteurs.index') }}" class="btn btn-secondary">
            ⬅️ Retour à la liste
        </a>
    </div>
</div>
@endsection