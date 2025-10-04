@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">📊 Liste des actions</h1>

    {{-- FORMULAIRE DE FILTRES --}}
    <form method="GET" class="card mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Promoteur</label>
                    <select name="promoteur_id" class="form-select">
                        <option value="">-- Tous --</option>
                        @foreach($promoteurs as $p)
                        <option value="{{ $p->id }}" {{ request('promoteur_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nom }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date début</label>
                    <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date fin</label>
                    <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Statut</label>
                    <select name="entreprise_active" class="form-select">
                        <option value="">-- Tous --</option>
                        <option value="1" {{ request('entreprise_active') === '1' ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ request('entreprise_active') === '0' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
                        <a href="{{ route('admin.actions.index') }}" class="btn btn-secondary">🔄 Reset</a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- BOUTONS D'EXPORT --}}
    <div class="mb-3">
        <a href="{{ route('admin.actions.export.excel', request()->all()) }}" class="btn btn-outline-success">
            ⬇️ Export Excel
        </a>
        <a href="{{ route('admin.actions.export.pdf', request()->all()) }}" class="btn btn-outline-danger">
            ⬇️ Export PDF
        </a>
    </div>

    {{-- TABLEAU DES ACTIONS --}}
    @if($actions->count())
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Date</th>
                        <th>Promoteur</th>
                        <th>Statut</th>
                        <th class="text-end">CA (FCFA)</th>
                        <th>Type suivi</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($actions as $action)
                    <tr>
                        <td>{{ $action->date_action->format('d/m/Y') }}</td>
                        <td>
                            <strong>{{ $action->promoteur->nom }}</strong>
                            <br><small class="text-muted">{{ $action->promoteur->projet }}</small>
                        </td>
                        <td>
                            <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $action->entreprise_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="text-end">
                            {{ $action->chiffre_affaires ? number_format($action->chiffre_affaires, 0, ',', ' ') : '-' }}
                        </td>
                        <td>{{ $action->type_suivi ?? '-' }}</td>
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

        @if($actions->hasPages())
        <div class="card-footer">
            {{ $actions->links() }}
        </div>
        @endif
    </div>
    @else
    <div class="alert alert-info text-center">
        <h5>Aucune action trouvée</h5>
        <p>{{ request()->hasAny(['promoteur_id', 'date_debut', 'entreprise_active']) ? 'Aucun résultat pour ces filtres.' : 'Aucune action enregistrée.' }}</p>
    </div>
    @endif
</div>
@endsection