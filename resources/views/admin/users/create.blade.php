@extends('layouts.admin')

@section('title', 'Créer un utilisateur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1><i class="bi bi-person-plus-fill"></i> Créer un utilisateur</h1>
        <p class="text-muted">Ajouter un nouvel utilisateur au système</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="bi bi-person"></i> Nom complet
                            </label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg"
                                value="{{ old('name') }}" required autofocus>
                            @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-bold">
                                <i class="bi bi-envelope"></i> Adresse email
                            </label>
                            <input type="email" name="email" id="email" class="form-control form-control-lg"
                                value="{{ old('email') }}" required>
                            @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">
                                    <i class="bi bi-lock"></i> Mot de passe
                                </label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" required>
                                @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold">
                                    <i class="bi bi-lock-fill"></i> Confirmer le mot de passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control form-control-lg" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold">
                                <i class="bi bi-shield-check"></i> Rôle
                            </label>
                            <select name="role" id="role" class="form-select form-select-lg" required>
                                <option value="">-- Sélectionner un rôle --</option>
                                <option value="rh" {{ old('role') === 'rh' ? 'selected' : '' }}>
                                    👤 RH (Ressources Humaines)
                                </option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    🛡️ Admin (Administrateur)
                                </option>
                            </select>
                            @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>Note :</strong> L'utilisateur recevra ses identifiants par email.
                        </div> -->

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle"></i> Créer l'utilisateur
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm bg-light">
                <div class="card-body p-4">
                    <h5 class="card-title">
                        <i class="bi bi-info-circle-fill text-primary"></i> Informations
                    </h5>
                    <hr>
                    <div class="mb-3">
                        <h6 class="fw-bold">Rôles disponibles :</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="badge bg-primary">RH</span>
                                <small class="text-muted d-block">Accès aux promoteurs et actions</small>
                            </li>
                            <li class="mb-2">
                                <span class="badge bg-danger">Admin</span>
                                <small class="text-muted d-block">Accès complet au système</small>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h6 class="fw-bold">Sécurité :</h6>
                        <small class="text-muted">
                            Le mot de passe doit contenir au moins 8 caractères.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection