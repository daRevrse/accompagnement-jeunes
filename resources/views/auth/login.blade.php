@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
        <h2 class="text-center mb-4">🔐 Connexion</h2>

        {{-- Message de succès (ex: mot de passe réinitialisé) --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        {{-- Formulaire de connexion --}}
        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Adresse e-mail</label>
                <input type="email" name="email" id="email"
                       class="form-control @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required autofocus>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Mot de passe --}}
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" id="password"
                       class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Se souvenir de moi --}}
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Se souvenir de moi</label>
            </div>

            {{-- Bouton de connexion --}}
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Connexion</button>
            </div>

            {{-- Lien vers l'inscription --}}
            <div class="text-center">
                <small>Pas encore inscrit ?
                    <a href="{{ route('register') }}" class="text-decoration-underline">Créer un compte</a>
                </small>
            </div>
        </form>
    </div>
</div>
@endsection
