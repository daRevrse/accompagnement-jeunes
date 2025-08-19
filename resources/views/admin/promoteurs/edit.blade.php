@extends('layouts.admin')

@section('title', 'Modifier un promoteur')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Modifier le promoteur</h1>

    <form method="POST" action="{{ route('promoteurs.update', $promoteur->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="{{ old('nom', $promoteur->nom) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $promoteur->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="telephone" class="form-label">Téléphone</label>
            <input type="text" name="telephone" id="telephone" class="form-control" value="{{ old('telephone', $promoteur->telephone) }}" required>
        </div>

        <div class="mb-3">
            <label for="projet" class="form-label">Projet</label>
            <input type="text" name="projet" id="projet" class="form-control" value="{{ old('projet', $promoteur->projet) }}">
        </div>

        <div class="mb-3">
            <label for="date_entree_accompagnement" class="form-label">Date d'entrée en accompagnement</label>
            <input type="date" name="date_entree_accompagnement" id="date_entree_accompagnement" class="form-control" value="{{ old('date_entree_accompagnement', $promoteur->date_entree_accompagnement) }}">
        </div>

        <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
        <a href="{{ route('promoteurs.index') }}" class="btn btn-secondary">↩️ Retour</a>
    </form>
</div>
@endsection