@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📄 Détail de l'action</h1>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            ⬅️ Retour
        </a>
    </div>

    <div class="row">
        <!-- Informations principales -->
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">📋 Informations générales</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>📅 Date du suivi :</strong><br>
                                {{ \Carbon\Carbon::parse($action->date_action)->format('d/m/Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>🔭 Type de suivi :</strong><br>
                                {{ $action->type_suivi ?? 'Non renseigné' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p><strong>🏢 Statut de l'entreprise :</strong><br>
                            <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }} fs-6">
                                {{ $action->entreprise_active ? 'Active' : 'Inactive' }}
                            </span>
                        </p>
                    </div>

                    @if(!$action->entreprise_active)
                    <div class="alert alert-warning">
                        <p class="mb-2"><strong>❓ Raison de l'inactivité :</strong><br>
                            {{ $action->raison_inactivite ?? 'Non renseignée' }}
                        </p>
                        <p class="mb-0"><strong>⚠️ Type d'arrêt :</strong><br>
                            {{ $action->arret_activite ? ucfirst($action->arret_activite) : 'Non renseigné' }}
                        </p>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>👥 Nombre d'emplois :</strong><br>
                                {{ $action->nombre_emplois ?? 'Non renseigné' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>⏳ Délais :</strong><br>
                                {{ $action->delais ? $action->delais . ' jours' : 'Non renseigné' }}
                            </p>
                        </div>
                    </div>

                    @if($action->date_echeance_action)
                    <p><strong>📅 Date d'échéance :</strong><br>
                        {{ \Carbon\Carbon::parse($action->date_echeance_action)->format('d/m/Y') }}
                    </p>
                    @endif
                </div>
            </div>

            <!-- Données financières -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">💰 Données financières</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <p><strong>💰 Chiffre d'affaires :</strong><br>
                                <span class="fs-5 text-success">
                                    {{ $action->chiffre_affaires ? number_format($action->chiffre_affaires, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>💸 Charges :</strong><br>
                                <span class="fs-5 text-danger">
                                    {{ $action->charge ? number_format($action->charge, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-4">
                            <p><strong>📈 Investissements :</strong><br>
                                <span class="fs-5 text-primary">
                                    {{ $action->investissements ? number_format($action->investissements, 0, ',', ' ') . ' FCFA' : 'Non renseigné' }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <p><strong>💳 Situation du crédit :</strong><br>
                        {{ $action->situation_credit ?? 'Non renseignée' }}
                    </p>
                </div>
            </div>

            <!-- Suivi et accompagnement -->
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">📝 Suivi et accompagnement</h5>
                </div>
                <div class="card-body">
                    @if($action->difficultes)
                    <div class="mb-3">
                        <p><strong>❓ Difficultés rencontrées :</strong></p>
                        <div class="alert alert-light border">{{ $action->difficultes }}</div>
                    </div>
                    @endif

                    @if($action->solutions)
                    <div class="mb-3">
                        <p><strong>✅ Solutions proposées :</strong></p>
                        <div class="alert alert-light border">{{ $action->solutions }}</div>
                    </div>
                    @endif

                    @if($action->action_faiej)
                    <div class="mb-3">
                        <p><strong>🏢 Action du FAIEJ :</strong></p>
                        <div class="alert alert-light border">{{ $action->action_faiej }}</div>
                    </div>
                    @endif

                    @if($action->observations)
                    <div class="mb-3">
                        <p><strong>📝 Observations :</strong></p>
                        <div class="alert alert-light border">{{ $action->observations }}</div>
                    </div>
                    @endif

                    @if($action->perspectives)
                    <div class="mb-3">
                        <p><strong>🔭 Perspectives :</strong></p>
                        <div class="alert alert-light border">{{ $action->perspectives }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Informations sur le promoteur -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">👤 Promoteur</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><strong>{{ $action->promoteur->nom }}</strong></p>
                    <p class="mb-2"><small class="text-muted">📧 {{ $action->promoteur->email }}</small></p>
                    <p class="mb-3"><small class="text-muted">📱 {{ $action->promoteur->telephone }}</small></p>
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $action->promoteur) : route('promoteurs.show', $action->promoteur) }}"
                        class="btn btn-sm btn-outline-primary w-100">
                        Voir le profil complet
                    </a>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="card">
                <div class="card-header bg-light">
                    <h6 class="mb-0">ℹ️ Métadonnées</h6>
                </div>
                <div class="card-body">
                    <p class="mb-2"><small><strong>Créé par :</strong><br>
                            {{ $action->createdBy->name ?? 'Système' }}</small></p>
                    <p class="mb-0"><small><strong>Date de création :</strong><br>
                            {{ $action->created_at->format('d/m/Y à H:i') }}</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection