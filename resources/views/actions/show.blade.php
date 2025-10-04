@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">
                        <i class="bi bi-journal-check"></i> Détail de l'action
                    </h2>
                    <p class="mb-0 opacity-75">
                        Action du {{ $action->date_action->format('d/m/Y') }} |
                        <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $action->entreprise_active ? 'Active' : 'Inactive' }}
                        </span>
                    </p>
                </div>
                <a href="{{ url()->previous() }}" class="btn btn-light">
                    <i class="bi bi-arrow-left-circle"></i> Retour
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Colonne principale -->
        <div class="col-lg-8">
            <!-- Informations générales -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="mb-0 text-black"><i class="bi bi-info-circle-fill text-primary"></i> Informations générales</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-calendar-check text-primary me-2"></i>
                                    <small class="text-muted">Date du suivi</small>
                                </div>
                                <div class="fw-bold">{{ $action->date_action->format('d/m/Y') }}</div>
                                <small class="text-muted">{{ $action->date_action->diffForHumans() }}</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-{{ $action->type_suivi === 'physique' ? 'person' : ($action->type_suivi === 'email' ? 'envelope' : 'telephone') }} text-info me-2"></i>
                                    <small class="text-muted">Type de suivi</small>
                                </div>
                                <div class="fw-bold">{{ ucfirst($action->type_suivi ?? 'Non renseigné') }}</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-hourglass-split text-warning me-2"></i>
                                    <small class="text-muted">Délais</small>
                                </div>
                                <div class="fw-bold">{{ $action->delais ? $action->delais . ' jours' : 'Non renseigné' }}</div>
                            </div>
                        </div>
                    </div>

                    @if(!$action->entreprise_active)
                    <div class="alert alert-danger mt-4">
                        <h6><i class="bi bi-exclamation-triangle-fill"></i> Entreprise inactive</h6>
                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <strong>Raison :</strong>
                                <p class="mb-0">{{ $action->raison_inactivite ?? 'Non renseignée' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Type d'arrêt :</strong>
                                <p class="mb-0">
                                    <span class="badge {{ $action->arret_activite === 'definitif' ? 'bg-danger' : 'bg-warning' }}">
                                        {{ $action->arret_activite ? ucfirst($action->arret_activite) : 'Non renseigné' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($action->date_echeance_action)
                    <div class="alert alert-info mt-4">
                        <i class="bi bi-calendar-event"></i>
                        <strong>Date d'échéance :</strong> {{ $action->date_echeance_action->format('d/m/Y') }}
                    </div>
                    @endif
                </div>
            </div>

            <!-- Données financières -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="mb-0 text-black"><i class="bi bi-currency-dollar text-success"></i> Données financières</h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); color: white;">
                                <div class="mb-2 opacity-75 small">Chiffre d'affaires</div>
                                <h3 class="mb-0 fw-bold">
                                    {{ $action->chiffre_affaires ? number_format($action->chiffre_affaires / 1000, 0) . 'K' : '-' }}
                                </h3>
                                <small class="opacity-75">FCFA</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #eb3349 0%, #f45c43 100%); color: white;">
                                <div class="mb-2 opacity-75 small">Charges</div>
                                <h3 class="mb-0 fw-bold">
                                    {{ $action->charge ? number_format($action->charge / 1000, 0) . 'K' : '-' }}
                                </h3>
                                <small class="opacity-75">FCFA</small>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="text-center p-4 rounded" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                <div class="mb-2 opacity-75 small">Investissements</div>
                                <h3 class="mb-0 fw-bold">
                                    {{ $action->investissements ? number_format($action->investissements / 1000, 0) . 'K' : '-' }}
                                </h3>
                                <small class="opacity-75">FCFA</small>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-people-fill text-primary me-2"></i>
                                    <small class="text-muted">Nombre d'emplois</small>
                                </div>
                                <div class="fw-bold fs-5">{{ $action->nombre_emplois ?? '-' }}</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 bg-light rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-credit-card text-warning me-2"></i>
                                    <small class="text-muted">Situation du crédit</small>
                                </div>
                                <div class="fw-bold">{{ $action->situation_credit ?? 'Non renseignée' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suivi et accompagnement -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="mb-0 text-black"><i class="bi bi-chat-left-text text-info"></i> Suivi et accompagnement</h5>
                </div>
                <div class="card-body p-4">
                    @if($action->difficultes)
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
                            <strong>Difficultés rencontrées</strong>
                        </div>
                        <div class="p-3 bg-light rounded">
                            {{ $action->difficultes }}
                        </div>
                    </div>
                    @endif

                    @if($action->solutions)
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-lightbulb-fill text-warning me-2"></i>
                            <strong>Solutions proposées</strong>
                        </div>
                        <div class="p-3 bg-light rounded">
                            {{ $action->solutions }}
                        </div>
                    </div>
                    @endif

                    @if($action->action_faiej)
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-building text-primary me-2"></i>
                            <strong>Action du FAIEJ</strong>
                        </div>
                        <div class="p-3 bg-light rounded">
                            {{ $action->action_faiej }}
                        </div>
                    </div>
                    @endif

                    @if($action->observations)
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-journal text-secondary me-2"></i>
                            <strong>Observations</strong>
                        </div>
                        <div class="p-3 bg-light rounded">
                            {{ $action->observations }}
                        </div>
                    </div>
                    @endif

                    @if($action->perspectives)
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-telescope text-info me-2"></i>
                            <strong>Perspectives</strong>
                        </div>
                        <div class="p-3 bg-light rounded">
                            {{ $action->perspectives }}
                        </div>
                    </div>
                    @endif

                    @if(!$action->difficultes && !$action->solutions && !$action->action_faiej && !$action->observations && !$action->perspectives)
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3">Aucune information de suivi enregistrée</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Colonne latérale -->
        <div class="col-lg-4">
            <!-- Informations sur le promoteur -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="mb-0 text-black"><i class="bi bi-person-badge"></i> Promoteur</h5>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 80px; height: 80px; font-size: 2rem;">
                            {{ substr($action->promoteur->nom, 0, 1) }}
                        </div>
                        <h5 class="mb-1">{{ $action->promoteur->nom }}</h5>
                        <p class="text-muted small mb-0">{{ $action->promoteur->projet }}</p>
                    </div>

                    <div class="border-top pt-3">
                        <div class="mb-2">
                            <small class="text-muted d-block">Email</small>
                            <div class="fw-bold small">
                                <i class="bi bi-envelope"></i> {{ $action->promoteur->email }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Téléphone</small>
                            <div class="fw-bold">
                                <i class="bi bi-telephone"></i> {{ $action->promoteur->telephone }}
                            </div>
                        </div>

                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $action->promoteur) : route('promoteurs.show', $action->promoteur) }}"
                            class="btn btn-outline-primary w-100">
                            <i class="bi bi-eye"></i> Voir le profil complet
                        </a>
                    </div>
                </div>
            </div>

            <!-- Métadonnées -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="mb-0 text-black"><i class="bi bi-clock-history"></i> Métadonnées</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                style="width: 40px; height: 40px;">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Créé par</small>
                                <div class="fw-bold">{{ $action->createdBy->name ?? 'Système' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 bg-light rounded">
                        <div class="mb-2">
                            <small class="text-muted">Date de création</small>
                            <div class="fw-bold">{{ $action->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        @if($action->updated_at != $action->created_at)
                        <div class="border-top pt-2 mt-2">
                            <small class="text-muted">Dernière modification</small>
                            <div class="fw-bold">{{ $action->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h6 class="mb-3"><i class="bi bi-lightning-charge"></i> Actions rapides</h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('actions.create', $action->promoteur) }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Nouvelle action
                        </a>
                        <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $action->promoteur) : route('promoteurs.show', $action->promoteur) }}"
                            class="btn btn-outline-primary">
                            <i class="bi bi-list-ul"></i> Historique complet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection