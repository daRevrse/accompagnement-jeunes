@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-person-plus-fill text-success" style="font-size: 3rem;"></i>
                            <h2 class="mt-3 fw-bold">Créer un compte</h2>
                            <p class="text-muted">Rejoignez la plateforme</p>
                        </div>

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Erreur :</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person text-muted"></i> Nom complet
                                </label>
                                <input type="text" name="name" id="name"
                                    class="form-control form-control-lg @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" required autofocus placeholder="John Doe">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope text-muted"></i> Adresse e-mail
                                </label>
                                <input type="email" name="email" id="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required placeholder="exemple@email.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill text-muted"></i> Confirmation
                                    </label>
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="form-control form-control-lg" required placeholder="••••••••">
                                </div>
                            </div>

                            <div class="alert alert-info mb-4">
                                <i class="bi bi-info-circle me-2"></i>
                                <small>Le mot de passe doit contenir au moins 8 caractères.</small>
                            </div>

                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>S'inscrire
                                </button>
                            </div>

                            <div class="text-center">
                                <p class="text-muted mb-2">Vous avez déjà un compte ?</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> Vos données sont protégées
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection