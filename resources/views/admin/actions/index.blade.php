@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">📊 Liste des actions</h1>

    {{-- FORMULAIRE DE FILTRE --}}
    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="promoteur_id" class="form-select">
                <option value="">-- Promoteur --</option>
                @foreach($promoteurs as $p)
                <option value="{{ $p->id }}" {{ request('promoteur_id') == $p->id ? 'selected' : '' }}>
                    {{ $p->nom }}
                </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input type="date" name="date_debut" class="form-control" value="{{ request('date_debut') }}">
        </div>
        <div class="col-md-2">
            <input type="date" name="date_fin" class="form-control" value="{{ request('date_fin') }}">
        </div>
        <div class="col-md-2">
            <select name="entreprise_active" class="form-select">
                <option value="">-- Statut --</option>
                <option value="1" {{ request('entreprise_active') === '1' ? 'selected' : '' }}>Active</option>
                <option value="0" {{ request('entreprise_active') === '0' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="col-md-3">
            <button class="btn btn-primary">🔍 Filtrer</button>
            <a href="{{ route('admin.actions.index') }}" class="btn btn-secondary">🔄 Réinitialiser</a>
        </div>
    </form>

    {{-- BOUTON D’EXPORT --}}
    <a href="{{ route('admin.actions.export.excel', request()->all()) }}" class="btn btn-outline-success mb-3">
        ⬇️ Exporter en Excel
    </a>

    <a href="{{ route('admin.actions.export.pdf', request()->all()) }}" class="btn btn-outline-danger mb-3">
        ⬇️ Exporter en PDF
    </a>


    {{-- TABLEAU DES ACTIONS --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Promoteur</th>
                    <th>Entreprise active</th>
                    <th>Chiffre d'affaires</th>
                    <th>Perspectives</th>
                </tr>
            </thead>
            <tbody>
                @forelse($actions as $a)
                <tr>
                    <td>{{ $a->date_action }}</td>
                    <td>{{ $a->promoteur->nom }}</td>
                    <td>{{ $a->entreprise_active ? 'Oui' : 'Non' }}</td>
                    <td>{{ $a->chiffre_affaires ?? '-' }}</td>
                    <td>{{ $a->perspectives ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">Aucune action trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- PAGINATION --}}
        {{ $actions->links() }}
    </div>
</div>
@endsection