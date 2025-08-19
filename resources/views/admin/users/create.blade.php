@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<h1 class="mb-4">➕ Créer un utilisateur</h1>

<form method="POST" action="{{ route('admin.users.store') }}" class="card p-4">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Nom</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirmation du mot de passe</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="role" class="form-label">Rôle</label>
        <select name="role" id="role" class="form-select" required>
            <!-- <option value="rh">Promoteur</option> -->
            <option value="rh">RH</option>
            <option value="admin">Admin</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">💾 Créer</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">↩️ Retour</a>
</form>
@endsection