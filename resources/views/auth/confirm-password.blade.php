@extends('layouts.app')

@section('title', 'Confirmer le mot de passe')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-check text-danger" style="font-size: 3rem;"></i>
                            <h2 class="mt-3 fw-bold">Zone sécurisée</h2>
                            <p class="text-muted">Veuillez confirmer votre mot de passe</p>
                        </div>

                        <div class="alert alert-warning mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <small>Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe pour continuer.</small>
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock text-muted"></i> Mot de passe
                                </label>
                                <input type="password" name="password" id="password"
                                    class="form-control form-control-lg @error('password') is-invalid @enderror"
                                    required autofocus placeholder="••••••••">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="bi bi-shield-check me-2"></i>Confirmer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-lock"></i> Confirmation de sécurité requise
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection