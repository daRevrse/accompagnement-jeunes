@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Modifier Promoteur</h1>

    <form method="POST" action="{{ route('promoteurs.update', $promoteur->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ old('nom', $promoteur->nom) }}">
            @error('nom')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $promoteur->email) }}">
            @error('email')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="telephone" class="form-control" value="{{ old('telephone', $promoteur->telephone) }}">
            @error('telephone')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Projet</label>
            <input type="text" name="projet" class="form-control" value="{{ old('projet', $promoteur->projet) }}">
            @error('projet')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <input type="date" name="date_entree_accompagnement" class="form-control" value="{{ old('date_entree_accompagnement', $promoteur->date_entree_accompagnement) }}">
            @error('date_entree_accompagnement')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">💾 Enregistrer</button>
        <a href="{{ route('promoteurs.index') }}" class="btn btn-secondary">↩️ Retour</a>
    </form>
</div>
@endsection
