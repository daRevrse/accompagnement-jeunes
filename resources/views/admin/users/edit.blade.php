@extends('layouts.admin')

@section('title', 'Modifier utilisateur')

@section('content')
<h1 class="mb-4">✏️ Modifier le rôle de {{ $user->nom }}</h1>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="card p-4">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select name="role" id="role" class="form-select" required>
            <option value="rh" {{ $user->role === 'rh' ? 'selected' : '' }}>RH</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Nouveau mot de passe (optionnel)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>


    <button type="submit" class="btn btn-success">💾 Enregistrer</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">↩️ Retour</a>
</form>
@endsection