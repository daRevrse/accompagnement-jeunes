@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container-fluid">
    <!-- En-tête avec informations du promoteur -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-person-circle me-3" style="font-size: 3rem;"></i>
                        <div>
                            <h2 class="mb-1">{{ $promoteur->nom }}</h2>
                            <p class="mb-0 opacity-75">
                                <i class="bi bi-briefcase"></i> {{ $promoteur->projet }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.edit', $promoteur) : route('promoteurs.edit', $promoteur) }}"
                        class="btn btn-light">
                        <i class="bi bi-pencil"></i> Modifier
                    </a>
                    <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Nouvelle action
                    </a>
                </div>
            </div>

            <div class="row mt-4 g-3">
                <div class="col-md-3">
                    <div class="p-3 bg-white bg-opacity-10 rounded">
                        <div class="small opacity-75">Email</div>
                        <div class="fw-bold"><i class="bi bi-envelope"></i> {{ $promoteur->email }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-white bg-opacity-10 rounded">
                        <div class="small opacity-75">Téléphone</div>
                        <div class="fw-bold"><i class="bi bi-telephone"></i> {{ $promoteur->telephone }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-white bg-opacity-10 rounded">
                        <div class="small opacity-75">Date d'entrée</div>
                        <div class="fw-bold">
                            <i class="bi bi-calendar-check"></i>
                            {{ $promoteur->date_entree_accompagnement ? $promoteur->date_entree_accompagnement->format('d/m/Y') : 'Non renseigné' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="p-3 bg-white bg-opacity-10 rounded">
                        <div class="small opacity-75">Statut entreprise</div>
                        <div class="fw-bold">
                            @if($stats['entreprise_active'])
                            <i class="bi bi-check-circle-fill text-success"></i> Active
                            @else
                            <i class="bi bi-x-circle-fill text-danger"></i> Inactive
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px;">
                    <div class="mb-2 opacity-75">Total actions</div>
                    <h1 class="mb-0 fw-bold">{{ $stats['total_actions'] }}</h1>
                    <div class="mt-2 small opacity-75">
                        <i class="bi bi-journal-text"></i> Suivis effectués
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); color: white; border-radius: 15px;">
                    <div class="mb-2 opacity-75">CA Total</div>
                    <h1 class="mb-0 fw-bold">{{ number_format($stats['ca_total'] / 1000, 0) }}K</h1>
                    <div class="mt-2 small opacity-75">
                        <i class="bi bi-currency-exchange"></i> FCFA
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px;">
                    <div class="mb-2 opacity-75">CA Moyen</div>
                    <h1 class="mb-0 fw-bold">{{ number_format($stats['ca_moyen'] / 1000, 0) }}K</h1>
                    <div class="mt-2 small opacity-75">
                        <i class="bi bi-graph-up-arrow"></i> Par action
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; border-radius: 15px;">
                    <div class="mb-2 opacity-75">Dernière action</div>
                    <h1 class="mb-0 fw-bold" style="font-size: 1.5rem;">
                        {{ $stats['derniere_action'] ? $stats['derniere_action']->date_action->format('d/m/Y') : '-' }}
                    </h1>
                    <div class="mt-2 small opacity-75">
                        <i class="bi bi-clock-history"></i> Date du suivi
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des actions -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="bi bi-list-check"></i> Historique des actions
                    <span class="badge bg-primary ms-2">{{ $stats['total_actions'] }}</span>
                </h4>
            </div>
        </div>

        @if($actions->count())
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <tr>
                        <th class="border-0">Date</th>
                        <th class="border-0">Statut</th>
                        <th class="border-0">Type suivi</th>
                        <th class="border-0 text-end">CA (FCFA)</th>
                        <th class="border-0 text-center">Emplois</th>
                        <th class="border-0">Créé par</th>
                        <th class="border-0 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actions as $action)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $action->date_action->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $action->date_action->diffForHumans() }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                                <i class="bi bi-{{ $action->entreprise_active ? 'check-circle' : 'x-circle' }}"></i>
                                {{ $action->entreprise_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            @if($action->type_suivi)
                            <span class="badge bg-info">
                                <i class="bi bi-{{ $action->type_suivi === 'physique' ? 'person' : ($action->type_suivi === 'email' ? 'envelope' : 'telephone') }}"></i>
                                {{ ucfirst($action->type_suivi) }}
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($action->chiffre_affaires)
                            <span class="fw-bold text-success">
                                {{ number_format($action->chiffre_affaires, 0, ',', ' ') }}
                            </span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($action->nombre_emplois)
                            <span class="badge bg-primary">{{ $action->nombre_emplois }}</span>
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 32px; height: 32px; font-size: 0.8rem;">
                                    {{ substr($action->createdBy->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="small">{{ $action->createdBy->name ?? 'Système' }}</span>
                            </div>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('actions.show', $action) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Détails
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($actions->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $actions->links() }}
        </div>
        @endif
        @else
        <div class="card-body text-center py-5">
            <div class="mb-3">
                <i class="bi bi-journal-x" style="font-size: 4rem; color: #ddd;"></i>
            </div>
            <h5 class="text-muted">Aucune action enregistrée</h5>
            <p class="text-muted">Ce promoteur n'a pas encore d'actions enregistrées.</p>
            <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> Créer la première action
            </a>
        </div>
        @endif
    </div>

    <!-- Bouton retour -->
    <div class="mt-4">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.index') : route('promoteurs.index') }}"
            class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left-circle"></i> Retour à la liste
        </a>
    </div>
</div>
@endsection