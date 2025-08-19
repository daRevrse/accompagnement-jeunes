{{-- resources/views/promoteurs/index.blade.php - VERSION OPTIMISÉE --}}
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>👥 Liste des promoteurs ({{ $promoteurs->total() }})</h1>
        <a href="{{ route('promoteurs.create') }}" class="btn btn-primary">
            ➕ Nouveau promoteur
        </a>
    </div>

    {{-- Formulaire de recherche optimisé --}}
    <form method="GET" action="{{ route('promoteurs.index') }}" class="mb-4">
        <div class="row g-3">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="Rechercher par nom, email ou projet...">
            </div>
            <div class="col-md-3">
                <select name="statut" class="form-select">
                    <option value="">Tous les statuts</option>
                    <option value="actif" {{ request('statut') === 'actif' ? 'selected' : '' }}>Entreprises actives</option>
                    <option value="inactif" {{ request('statut') === 'inactif' ? 'selected' : '' }}>Entreprises inactives</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">🔍 Rechercher</button>
            </div>
        </div>
    </form>

    @if($promoteurs->count())
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Projet</th>
                        <th>Date d'entrée</th>
                        <th>Dernière action</th>
                        <th>Statut</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promoteurs as $promoteur)
                    @php
                    // Récupérer la dernière action de manière optimisée
                    $derniereAction = $promoteur->actions->first();
                    @endphp
                    <tr>
                        <td>
                            <strong>{{ $promoteur->nom }}</strong>
                            <br><small class="text-muted">{{ $promoteur->email }}</small>
                        </td>
                        <td>{{ Str::limit($promoteur->projet, 30) }}</td>
                        <td>
                            {{ $promoteur->date_entree_accompagnement ? $promoteur->date_entree_accompagnement->format('d/m/Y') : '-' }}
                        </td>
                        <td>
                            @if($derniereAction)
                            {{ $derniereAction->date_action->format('d/m/Y') }}
                            <br><small class="text-muted">{{ $derniereAction->chiffre_affaires ? number_format($derniereAction->chiffre_affaires, 0, ',', ' ') . ' FCFA' : 'Pas de CA' }}</small>
                            @else
                            <span class="text-muted">Aucune action</span>
                            @endif
                        </td>
                        <td>
                            @if($derniereAction)
                            <span class="badge {{ $derniereAction->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $derniereAction->entreprise_active ? 'Active' : 'Inactive' }}
                            </span>
                            @else
                            <span class="badge bg-secondary">Inconnu</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('promoteurs.show', $promoteur) }}" class="btn btn-outline-info" title="Voir les détails">
                                    👁️
                                </a>
                                <a href="{{ route('promoteurs.edit', $promoteur) }}" class="btn btn-outline-primary" title="Modifier">
                                    ✏️
                                </a>
                                <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-outline-success" title="Nouvelle action">
                                    ➕
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($promoteurs->hasPages())
        <div class="card-footer">
            {{ $promoteurs->links() }}
        </div>
        @endif
    </div>
    @else
    <div class="alert alert-info text-center">
        <h4>Aucun promoteur trouvé</h4>
        <p>{{ request('search') ? 'Aucun résultat pour votre recherche.' : 'Aucun promoteur enregistré.' }}</p>
        @if(!request('search'))
        <a href="{{ route('promoteurs.create') }}" class="btn btn-primary">
            ➕ Créer le premier promoteur
        </a>
        @endif
    </div>
    @endif
</div>
@endsection