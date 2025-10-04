@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-journal-text"></i> Toutes les actions</h1>
            <p class="text-muted mb-0">Suivi complet des actions enregistrées</p>
        </div>
    </div>

    {{-- FORMULAIRE DE FILTRES --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <form method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Promoteur</label>
                        <select name="promoteur_id" class="form-select">
                            <option value="">-- Tous les promoteurs --</option>
                            @foreach($promoteurs as $p)
                            <option value="{{ $p->id }}" {{ request('promoteur_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nom }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Date début</label>
                        <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Date fin</label>
                        <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">Statut</label>
                        <select name="entreprise_active" class="form-select">
                            <option value="">-- Tous --</option>
                            <option value="1" {{ request('entreprise_active') === '1' ? 'selected' : '' }}>✅ Active</option>
                            <option value="0" {{ request('entreprise_active') === '0' ? 'selected' : '' }}>❌ Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel"></i> Filtrer
                            </button>
                            <a href="{{ route('admin.actions.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- BOUTONS D'EXPORT --}}
    <div class="mb-4">
        <a href="{{ route('admin.actions.export.excel', request()->all()) }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.actions.export.pdf', request()->all()) }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    {{-- STATISTIQUES RAPIDES --}}
    @if($actions->total() > 0)
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 text-center">
                    <div class="fw-bold text-primary" style="font-size: 2rem;">{{ $actions->total() }}</div>
                    <small class="text-muted">Actions trouvées</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 text-center">
                    <div class="fw-bold text-success" style="font-size: 2rem;">
                        {{ $actions->where('entreprise_active', true)->count() }}
                    </div>
                    <small class="text-muted">Entreprises actives</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 text-center">
                    <div class="fw-bold text-danger" style="font-size: 2rem;">
                        {{ $actions->where('entreprise_active', false)->count() }}
                    </div>
                    <small class="text-muted">Entreprises inactives</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-3 text-center">
                    <div class="fw-bold text-info" style="font-size: 1.2rem;">
                        {{ number_format($actions->sum('chiffre_affaires') / 1000000, 1) }}M
                    </div>
                    <small class="text-muted">CA Total (FCFA)</small>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- TABLEAU DES ACTIONS --}}
    @if($actions->count())
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <tr>
                        <th class="border-0">Date</th>
                        <th class="border-0">Promoteur</th>
                        <th class="border-0">Statut</th>
                        <th class="border-0 text-end">CA (FCFA)</th>
                        <th class="border-0">Type suivi</th>
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
                            <div class="d-flex align-items-center">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                    style="width: 35px; height: 35px; font-size: 0.9rem;">
                                    {{ substr($action->promoteur->nom, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold">{{ $action->promoteur->nom }}</div>
                                    <small class="text-muted">{{ Str::limit($action->promoteur->projet, 30) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                                <i class="bi bi-{{ $action->entreprise_active ? 'check-circle' : 'x-circle' }}"></i>
                                {{ $action->entreprise_active ? 'Active' : 'Inactive' }}
                            </span>
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
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('actions.show', $action) }}" class="btn btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.promoteurs.show', $action->promoteur) }}" class="btn btn-outline-secondary" title="Voir le promoteur">
                                    <i class="bi bi-person"></i>
                                </a>
                            </div>
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
    </div>
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ddd;"></i>
            </div>
            <h4>Aucune action trouvée</h4>
            <p class="text-muted">
                {{ request()->hasAny(['promoteur_id', 'date_debut', 'entreprise_active']) ? 'Aucun résultat pour ces filtres.' : 'Aucune action enregistrée.' }}
            </p>
        </div>
    </div>
    @endif
</div>
@endsection