@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">👥 Liste des promoteurs</h1>

    <!-- Formulaire de recherche -->
    <form method="GET" action="{{ route('admin.promoteurs.index') }}" class="mb-4 d-flex">
        <input type="text" name="search" value="{{ request('search') }}"
            class="form-control me-2" placeholder="Rechercher un promoteur ">
        <button type="submit" class="btn btn-outline-primary">🔎 Rechercher</button>
    </form>

    <a href="{{ route('promoteurs.create') }}" class="btn btn-sm btn-primary mb-4">
        ➕ Ajouter
    </a>

    @if($promoteurs->isEmpty())
    <div class="alert alert-info">
        Aucun promoteur enregistré pour le moment.
    </div>
    @else
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Projet</th>
                    <th scope="col"></th>
                    <th scope="col" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($promoteurs as $promoteur)
                <tr>
                    <td>{{ $promoteur->nom }}</td>
                    <td>{{ $promoteur->projet }}</td>
                    <td>{{ $promoteur->date_entree_accompagnement }}</td>
                    <td class="text-center">
                        <a href="{{ route('promoteurs.show', $promoteur->id) }}" class="btn btn-sm btn-primary">
                            📄 Détails
                        </a>

                        <a href="{{ route('promoteurs.edit', $promoteur->id) }}" class="btn btn-sm btn-primary">
                            📄 Modifier
                        </a>
                        {{-- Bouton de suppression fonctionnel --}}
                        <form action="{{ route('promoteurs.destroy', $promoteur->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce promoteur ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                🗑️ Supprimer
                            </button>
                        </form>


                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection