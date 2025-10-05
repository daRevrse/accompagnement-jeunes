@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-people-fill"></i> Gestion des promoteurs</h1>
            <p class="text-muted mb-0">{{ $promoteurs->total() }} promoteur(s) enregistré(s)</p>
        </div>
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.create') : route('promoteurs.create') }}"
            class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nouveau promoteur
        </a>
    </div>

    {{-- Formulaire de recherche moderne --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.index') : route('promoteurs.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control border-start-0" placeholder="Rechercher par nom, email ou projet...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="statut" class="form-select">
                            <option value="">📊 Tous les statuts</option>
                            <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>
                                ✅ Entreprises actives
                            </option>
                            <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>
                                ❌ Entreprises inactives
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Filtrer
                        </button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-outline-secondary w-100" id="switchBtn" onclick="switchView()">
                            <i class="bi bi-list"></i> Vue liste
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="mb-4">
        <a href="{{ route('admin.promoteurs.export.excel') }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.promoteurs.export.pdf') }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>
    @endif

    @if($promoteurs->count())
    {{-- VUE CARTES (par défaut) --}}
    <div id="cardView" class="row g-4">
        @foreach($promoteurs as $promoteur)
        @php
        $derniereAction = $promoteur->actions->first();
        @endphp
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-person-circle text-primary"></i>
                                {{ $promoteur->nom }}
                            </h5>
                            <p class="text-muted mb-0 small">
                                <i class="bi bi-envelope"></i> {{ $promoteur->email }}
                            </p>
                        </div>
                        @if($derniereAction)
                        <span class="badge {{ $derniereAction->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $derniereAction->entreprise_active ? '✓ Active' : '✗ Inactive' }}
                        </span>
                        @else
                        <span class="badge bg-secondary">Aucune action</span>
                        @endif
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <div class="small text-muted">Projet</div>
                                <div class="fw-bold text-truncate" title="{{ $promoteur->projet }}">
                                    {{ Str::limit($promoteur->projet, 20) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 bg-light rounded">
                                <div class="small text-muted">Accompagnement</div>
                                <div class="fw-bold">
                                    {{ $promoteur->date_entree_accompagnement ? $promoteur->date_entree_accompagnement->format('d/m/Y') : 'Non renseigné' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($derniereAction)
                    <div class="p-3 bg-light rounded mb-3">
                        <div class="small text-muted mb-1">Dernière action</div>
                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">{{ $derniereAction->date_action->format('d/m/Y') }}</span>
                            <span class="text-success fw-bold">
                                {{ $derniereAction->chiffre_affaires ? number_format($derniereAction->chiffre_affaires, 0, ',', ' ') . ' FCFA' : '-' }}
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $promoteur) : route('promoteurs.show', $promoteur) }}"
                            class="btn btn-outline-primary btn-sm flex-grow-1">
                            <i class="bi bi-eye"></i> Voir
                        </a>
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.edit', $promoteur) : route('promoteurs.edit', $promoteur) }}"
                            class="btn btn-outline-warning btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="{{ route('actions.create', $promoteur) }}"
                            class="btn btn-outline-success btn-sm">
                            <i class="bi bi-plus"></i>
                        </a>

                        @if(auth()->user()->role === 'admin')
                        <form action="{{ route('admin.promoteurs.destroy', $promoteur) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Confirmer la suppression de {{ $promoteur->nom }} ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- VUE LISTE (cachée par défaut) --}}
    <div id="listView" class="d-none">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Email</th>
                                <th>Projet</th>
                                <th>Statut</th>
                                <th>CA (dernier)</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promoteurs as $promoteur)
                            @php
                            $derniereAction = $promoteur->actions->first();
                            @endphp
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                            style="width: 35px; height: 35px; font-size: 0.9rem;">
                                            {{ substr($promoteur->nom, 0, 1) }}
                                        </div>
                                        <strong>{{ $promoteur->nom }}</strong>
                                    </div>
                                </td>
                                <td>{{ $promoteur->email }}</td>
                                <td>{{ Str::limit($promoteur->projet, 30) }}</td>
                                <td>
                                    @if($derniereAction)
                                    <span class="badge {{ $derniereAction->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $derniereAction->entreprise_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">Aucune action</span>
                                    @endif
                                </td>
                                <td>
                                    @if($derniereAction && $derniereAction->chiffre_affaires)
                                    <span class="text-success fw-bold">
                                        {{ number_format($derniereAction->chiffre_affaires, 0, ',', ' ') }} FCFA
                                    </span>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td class="text-end">
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $promoteur) : route('promoteurs.show', $promoteur) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.edit', $promoteur) : route('promoteurs.edit', $promoteur) }}"
                                        class="btn btn-sm btn-outline-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="{{ route('actions.create', $promoteur) }}"
                                        class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-plus"></i>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('admin.promoteurs.destroy', $promoteur) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Confirmer la suppression ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @if($promoteurs->hasPages())
    <div class="mt-4">
        {{ $promoteurs->links() }}
    </div>
    @endif
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            </div>
            <h4>Aucun promoteur trouvé</h4>
            <p class="text-muted">
                {{ request('search') ? 'Aucun résultat pour votre recherche.' : 'Aucun promoteur enregistré.' }}
            </p>
            @if(!request('search'))
            <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.create') : route('promoteurs.create') }}"
                class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> Créer le premier promoteur
            </a>
            @endif
        </div>
    </div>
    @endif
</div>

{{-- Script Vue Switch --}}
<script>
    let isCardView = true;

    function switchView() {
        const cardView = document.getElementById('cardView');
        const listView = document.getElementById('listView');
        const btn = document.getElementById('switchBtn');

        if (isCardView) {
            cardView.classList.add('d-none');
            listView.classList.remove('d-none');
            btn.innerHTML = '<i class="bi bi-grid-3x3-gap"></i> Vue cartes';
        } else {
            listView.classList.add('d-none');
            cardView.classList.remove('d-none');
            btn.innerHTML = '<i class="bi bi-list"></i> Vue liste';
        }

        isCardView = !isCardView;
    }
</script>
@endsection