@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-key-fill text-warning" style="font-size: 3rem;"></i>
                            <h2 class="mt-3 fw-bold">Mot de passe oublié</h2>
                            <p class="text-muted">Réinitialisez votre mot de passe</p>
                        </div>

                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            <small>Indiquez votre adresse e-mail et nous vous enverrons un lien pour réinitialiser votre mot de passe.</small>
                        </div>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-muted"></i> Adresse e-mail
                                </label>
                                <input type="email" name="email" id="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required autofocus placeholder="exemple@email.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-warning btn-lg">
                                    <i class="bi bi-envelope-paper me-2"></i>Envoyer le lien
                                </button>
                            </div>

                            <div class="text-center">
                                <a href="{{ route('login') }}" class="text-decoration-none">
                                    <i class="bi bi-arrow-left me-2"></i>Retour à la connexion
                                </a>
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