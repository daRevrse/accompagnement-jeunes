@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
                            <h2 class="mt-3 fw-bold">Nouveau mot de passe</h2>
                            <p class="text-muted">Définissez votre nouveau mot de passe</p>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-muted"></i> Adresse e-mail
                                </label>
                                <input type="email" name="email" id="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email', $request->email) }}" required autofocus>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock text-muted"></i> Nouveau mot de passe
                                </label>
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    required placeholder="••••••••">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-lock-fill text-muted"></i> Confirmer le mot de passe
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                    class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror"
                                    required placeholder="••••••••">
                                @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>Le mot de passe doit contenir au moins 8 caractères.</small>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Réinitialiser le mot de passe
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> Processus sécurisé
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection