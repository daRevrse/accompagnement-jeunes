@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-speedometer2"></i> Tableau de bord</h1>
            <p class="text-muted mb-0">Bienvenue {{ auth()->user()->name }}</p>
        </div>
        <span class="badge bg-primary fs-6">{{ now()->locale('fr_FR')->isoFormat('dddd D MMMM YYYY') }}</span>
    </div>

    {{-- Statistiques principales --}}
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Promoteurs</h6>
                            <h2 class="mb-0 fw-bold">{{ $nbPromoteurs }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('promoteurs.index') }}" class="text-white text-decoration-none small">
                            <i class="bi bi-arrow-right-circle me-1"></i> Voir tous
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Actions</h6>
                            <h2 class="mb-0 fw-bold">{{ $nbActions }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-journal-text"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="bi bi-graph-up me-1"></i> Suivis effectués
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Entreprises actives</h6>
                            <h2 class="mb-0 fw-bold">{{ $nbActives ?? 0 }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-building-check"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="bi bi-check-circle me-1"></i> En activité
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Entreprises inactives</h6>
                            <h2 class="mb-0 fw-bold">{{ $nbInactives ?? 0 }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-building-x"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <small class="opacity-75">
                            <i class="bi bi-exclamation-circle me-1"></i> À suivre
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions rapides --}}
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-person-plus-fill" style="font-size: 3rem; color: #667eea;"></i>
                    </div>
                    <h5 class="card-title">Ajouter un promoteur</h5>
                    <p class="text-muted">Enregistrer un nouveau promoteur dans le système</p>
                    <a href="{{ route('promoteurs.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nouveau promoteur
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #56ab2f;"></i>
                    </div>
                    <h5 class="card-title">Consulter les promoteurs</h5>
                    <p class="text-muted">Voir la liste complète des promoteurs enregistrés</p>
                    <a href="{{ route('promoteurs.index') }}" class="btn btn-success">
                        <i class="bi bi-list-ul"></i> Liste des promoteurs
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Derniers promoteurs ajoutés --}}
    @if(isset($derniersPromoteurs) && $derniersPromoteurs->count())
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-0 p-4">
            <h5 class="mb-0">
                <i class="bi bi-clock-history"></i> Derniers promoteurs ajoutés
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Projet</th>
                            <th>Date d'ajout</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($derniersPromoteurs as $promoteur)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 35px; height: 35px; font-size: 0.9rem;">
                                        {{ substr($promoteur->nom, 0, 1) }}
                                    </div>
                                    <strong>{{ $promoteur->nom }}</strong>
                                </div>
                            </td>
                            <td>{{ $promoteur->email }}</td>
                            <td>{{ Str::limit($promoteur->projet, 30) }}</td>
                            <td>
                                <i class="bi bi-calendar-check text-muted"></i>
                                {{ $promoteur->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('promoteurs.show', $promoteur) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Voir
                                </a>
                                <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-plus"></i> Action
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 text-center">
            <a href="{{ route('promoteurs.index') }}" class="text-decoration-none">
                Voir tous les promoteurs <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    @endif
</div>
@endsection