@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
                            <h2 class="mt-3 fw-bold">Connexion</h2>
                            <p class="text-muted">Accédez à votre espace</p>
                        </div>

                        @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
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

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock text-muted"></i> Mot de passe
                                </label>
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    required placeholder="••••••••">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                    <label for="remember" class="form-check-label">Se souvenir de moi</label>
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted mb-2">Pas encore de compte ?</p>
                                <a href="{{ route('register') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-person-plus me-2"></i>Créer un compte
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> Connexion sécurisée
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection