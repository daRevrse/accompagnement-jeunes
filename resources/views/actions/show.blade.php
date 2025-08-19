@extends('layouts.app')

@section('title', 'Détail de l\'action')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">📄 Détail de l'action du {{ \Carbon\Carbon::parse($action->date_action)->format('d/m/Y') }}</h1>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Entreprise active :</strong>
                <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                    {{ $action->entreprise_active ? 'Oui' : 'Non' }}
                </span>
            </p>

            @if(!$action->entreprise_active)
                <p><strong>Raison de l'inactivité :</strong> {{ $action->raison_inactivite ?? 'Non renseignée' }}</p>
                <p><strong>Arrêt de l'activité :</strong> {{ $action->arret_activite ?? 'Non renseigné' }}</p>
            @endif

            <p><strong>Chiffre d'affaires :</strong>
                {{ $action->chiffre_affaires ? number_format($action->chiffre_affaires, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}
            </p>

            <p><strong>Investissements :</strong> {{ $action->investissements ?? 'Non renseigné' }}</p>
            <p><strong>Perspectives :</strong> {{ $action->perspectives ?? 'Non renseignées' }}</p>
            <p><strong>Commentaire :</strong> {{ $action->commentaire ?? 'Aucun' }}</p>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">⬅️ Retour</a>
    </div>
</div>
@endsection
