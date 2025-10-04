@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container">
    <!-- En-tête avec informations du promoteur -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">👤 {{ $promoteur->nom }}</h1>
            <p class="text-muted mb-0">{{ $promoteur->projet }}</p>
        </div>
        <div>
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.edit', $promoteur) : route('promoteurs.edit', $promoteur) }}"
                class="btn btn-outline-primary me-2">
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
                    <div class="d-flex justify-content-between mb-2">
                        <span>Statut entreprise :</span>
                        <span class="badge {{ $stats['entreprise_active'] ? 'bg-success' : 'bg-danger' }}">
                            {{ $stats['entreprise_active'] ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des actions -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">📝 Actions réalisées ({{ $stats['total_actions'] }})</h5>
        </div>

        @if($actions->count())
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Statut</th>
                        <th>Type suivi</th>
                        <th class="text-end">CA (FCFA)</th>
                        <th class="text-end">Emplois</th>
                        <th>Créé par</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actions as $action)
                    <tr>
                        <td>{{ $action->date_action->format('d/m/Y') }}</td>
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
        @if($actions->hasPages())
        <div class="card-footer">
            {{ $actions->links() }}
        </div>
        @endif
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
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.index') : route('promoteurs.index') }}"
            class="btn btn-secondary">
            ⬅️ Retour à la liste
        </a>
    </div>
</div>
@endsection