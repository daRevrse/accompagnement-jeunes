@extends('layouts.admin')

@section('title', 'Modifier utilisateur')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h1><i class="bi bi-pencil-square"></i> Modifier l'utilisateur</h1>
        <p class="text-muted">Modification de {{ $user->name }}</p>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        {{-- Informations de base (lecture seule) --}}
                        <div class="mb-4 p-3 bg-light rounded">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label fw-bold text-muted small">Nom</label>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted small">Email</label>
                                    <div class="fw-bold">{{ $user->email }}</div>
                                </div>
                            </div>
                        </div>

                        {{-- Modification du rôle --}}
                        <div class="mb-4">
                            <label for="role" class="form-label fw-bold">
                                <i class="bi bi-shield-check"></i> Rôle
                            </label>
                            <select name="role" id="role" class="form-select form-select-lg" required>
                                <option value="rh" {{ $user->role === 'rh' ? 'selected' : '' }}>
                                    👤 RH (Ressources Humaines)
                                </option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>
                                    🛡️ Admin (Administrateur)
                                </option>
                            </select>
                            @error('role')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr class="my-4">

                        {{-- Changement de mot de passe (optionnel) --}}
                        <div class="mb-3">
                            <h5 class="mb-3">
                                <i class="bi bi-key"></i> Changer le mot de passe
                                <small class="text-muted">(optionnel)</small>
                            </h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-bold">
                                    <i class="bi bi-lock"></i> Nouveau mot de passe
                                </label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg">
                                <small class="text-muted">Laissez vide pour conserver le mot de passe actuel</small>
                                @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-bold">
                                    <i class="bi bi-lock-fill"></i> Confirmer le mot de passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control form-control-lg">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle"></i> Enregistrer les modifications
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
                        <i class="bi bi-person-circle text-primary"></i> Informations
                    </h5>
                    <hr>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Créé le</small>
                        <div class="fw-bold">{{ $user->created_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Dernière modification</small>
                        <div class="fw-bold">{{ $user->updated_at->format('d/m/Y à H:i') }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block mb-1">Rôle actuel</small>
                        @if($user->role === 'admin')
                        <span class="badge bg-danger">
                            <i class="bi bi-shield-lock-fill"></i> Admin
                        </span>
                        @else
                        <span class="badge bg-primary">
                            <i class="bi bi-person-badge"></i> RH
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-3">
                <div class="card-body p-4">
                    <h6 class="text-danger mb-3">
                        <i class="bi bi-exclamation-triangle-fill"></i> Zone de danger
                    </h6>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                        onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer {{ $user->name }} ? Cette action est irréversible.')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash"></i> Supprimer l'utilisateur
                        </button>
                    </form>
                    @else
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-shield-check"></i>
                        Vous ne pouvez pas supprimer votre propre compte.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection