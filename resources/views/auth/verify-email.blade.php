@extends('layouts.app')

@section('title', 'Vérification d\'email')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-envelope-check-fill text-info" style="font-size: 3rem;"></i>
                            <h2 class="mt-3 fw-bold">Vérifiez votre email</h2>
                        </div>

                        <div class="alert alert-info mb-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Merci de vous être inscrit ! Avant de commencer, veuillez vérifier votre adresse e-mail en cliquant sur le lien que nous venons de vous envoyer. Si vous n'avez pas reçu l'e-mail, nous vous en enverrons un autre avec plaisir.
                        </div>

                        @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="bi bi-check-circle me-2"></i>
                            Un nouveau lien de vérification a été envoyé à l'adresse e-mail que vous avez fournie lors de votre inscription.
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-info">
                                    <i class="bi bi-envelope-paper me-2"></i>Renvoyer l'email
                                </button>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary">
                                    <i class="bi bi-box-arrow-right me-2"></i>Se déconnecter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small class="text-muted">
                        <i class="bi bi-shield-check"></i> Vérification de sécurité
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection