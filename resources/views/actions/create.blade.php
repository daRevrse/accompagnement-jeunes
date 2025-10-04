@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container-fluid">
    <!-- En-tête -->
    <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); color: white;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <i class="bi bi-plus-circle-fill me-3" style="font-size: 3rem;"></i>
                <div>
                    <h2 class="mb-1">Nouvelle action de suivi</h2>
                    <p class="mb-0 opacity-75">
                        <i class="bi bi-person-circle"></i> Promoteur : <strong>{{ $promoteur->nom }}</strong>
                        | <i class="bi bi-briefcase"></i> {{ $promoteur->projet }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('actions.store', $promoteur->id) }}">
        @csrf

        <div class="row g-4">
            <!-- Colonne principale -->
            <div class="col-lg-8">

                <!-- Informations générales -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h5 class="mb-0"><i class="bi bi-info-circle"></i> Informations générales</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="date_action" class="form-label fw-semibold">
                                    Date du suivi <span class="text-danger">*</span>
                                </label>
                                <input type="date" name="date_action" id="date_action"
                                    class="form-control @error('date_action') is-invalid @enderror"
                                    value="{{ old('date_action', date('Y-m-d')) }}" required>
                                @error('date_action')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="type_suivi" class="form-label fw-semibold">Type de suivi</label>
                                <select name="type_suivi" id="type_suivi" class="form-select @error('type_suivi') is-invalid @enderror">
                                    <option value="">-- Sélectionner --</option>
                                    <option value="physique" {{ old('type_suivi') == 'physique' ? 'selected' : '' }}>
                                        📍 Physique
                                    </option>
                                    <option value="téléphonique" {{ old('type_suivi') == 'téléphonique' ? 'selected' : '' }}>
                                        📞 Téléphonique
                                    </option>
                                    <option value="email" {{ old('type_suivi') == 'email' ? 'selected' : '' }}>
                                        📧 Email
                                    </option>
                                </select>
                                @error('type_suivi')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="delais" class="form-label fw-semibold">
                                    Délais (jours) <span class="text-danger">*</span>
                                </label>
                                <input type="number" name="delais" id="delais"
                                    class="form-control @error('delais') is-invalid @enderror"
                                    value="{{ old('delais') }}" required>
                                @error('delais')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <label for="entreprise_active" class="form-label fw-semibold">
                                Statut de l'entreprise <span class="text-danger">*</span>
                            </label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="entreprise_active" id="active_oui" value="1"
                                    {{ old('entreprise_active', '1') == '1' ? 'checked' : '' }}>
                                <label class="btn btn-outline-success" for="active_oui">
                                    <i class="bi bi-check-circle"></i> Entreprise Active
                                </label>

                                <input type="radio" class="btn-check" name="entreprise_active" id="active_non" value="0"
                                    {{ old('entreprise_active') == '0' ? 'checked' : '' }}>
                                <label class="btn btn-outline-danger" for="active_non">
                                    <i class="bi bi-x-circle"></i> Entreprise Inactive
                                </label>
                            </div>
                        </div>

                        <!-- Section conditionnelle inactivité -->
                        <div id="section_inactivite" class="mt-3" style="display: none;">
                            <div class="alert alert-warning">
                                <h6><i class="bi bi-exclamation-triangle"></i> Informations sur l'inactivité</h6>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Raison de l'inactivité</label>
                                        <textarea name="raison_inactivite" class="form-control" rows="2">{{ old('raison_inactivite') }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Type d'arrêt</label>
                                        <select name="arret_activite" class="form-select">
                                            <option value="">-- Sélectionner --</option>
                                            <option value="provisoire" {{ old('arret_activite') == 'provisoire' ? 'selected' : '' }}>
                                                Provisoire
                                            </option>
                                            <option value="definitif" {{ old('arret_activite') == 'definitif' ? 'selected' : '' }}>
                                                Définitif
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Données financières -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h5 class="mb-0"><i class="bi bi-currency-exchange"></i> Données financières</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="chiffre_affaires" class="form-label fw-semibold">
                                    <i class="bi bi-cash-stack text-success"></i> CA mensuel (FCFA)
                                </label>
                                <input type="number" step="0.01" name="chiffre_affaires" id="chiffre_affaires"
                                    class="form-control @error('chiffre_affaires') is-invalid @enderror"
                                    value="{{ old('chiffre_affaires') }}" placeholder="0">
                                @error('chiffre_affaires')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="charge" class="form-label fw-semibold">
                                    <i class="bi bi-receipt text-danger"></i> Charges (FCFA)
                                </label>
                                <input type="number" step="0.01" name="charge"
                                    class="form-control @error('charge') is-invalid @enderror"
                                    value="{{ old('charge') }}" placeholder="0">
                                @error('charge')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="investissements" class="form-label fw-semibold">
                                    <i class="bi bi-graph-up-arrow text-primary"></i> Investissements (FCFA)
                                </label>
                                <input type="number" step="0.01" name="investissements"
                                    class="form-control @error('investissements') is-invalid @enderror"
                                    value="{{ old('investissements') }}" placeholder="0">
                                @error('investissements')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mt-2">
                            <div class="col-md-6">
                                <label for="nombre_emplois" class="form-label fw-semibold">
                                    <i class="bi bi-people"></i> Nombre d'emplois
                                </label>
                                <input type="number" name="nombre_emplois"
                                    class="form-control @error('nombre_emplois') is-invalid @enderror"
                                    value="{{ old('nombre_emplois') }}" placeholder="0">
                                @error('nombre_emplois')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="situation_credit" class="form-label fw-semibold">
                                    <i class="bi bi-credit-card"></i> Situation du crédit
                                </label>
                                <input type="text" name="situation_credit"
                                    class="form-control @error('situation_credit') is-invalid @enderror"
                                    value="{{ old('situation_credit') }}" placeholder="Ex: En cours">
                                @error('situation_credit')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suivi et accompagnement -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h5 class="mb-0"><i class="bi bi-chat-left-text"></i> Suivi et accompagnement</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="difficultes" class="form-label fw-semibold">
                                <i class="bi bi-exclamation-triangle text-warning"></i> Difficultés rencontrées
                            </label>
                            <textarea name="difficultes" id="difficultes" rows="3"
                                class="form-control @error('difficultes') is-invalid @enderror"
                                placeholder="Décrivez les difficultés...">{{ old('difficultes') }}</textarea>
                            @error('difficultes')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="solutions" class="form-label fw-semibold">
                                <i class="bi bi-lightbulb text-warning"></i> Solutions proposées
                            </label>
                            <textarea name="solutions" id="solutions" rows="3"
                                class="form-control @error('solutions') is-invalid @enderror"
                                placeholder="Proposez des solutions...">{{ old('solutions') }}</textarea>
                            @error('solutions')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="action_faiej" class="form-label fw-semibold">
                                <i class="bi bi-building text-primary"></i> Action du FAIEJ
                            </label>
                            <textarea name="action_faiej" id="action_faiej" rows="3"
                                class="form-control @error('action_faiej') is-invalid @enderror"
                                placeholder="Action entreprise par le FAIEJ...">{{ old('action_faiej') }}</textarea>
                            @error('action_faiej')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="observations" class="form-label fw-semibold">
                                <i class="bi bi-journal"></i> Observations
                            </label>
                            <textarea name="observations" id="observations" rows="3"
                                class="form-control @error('observations') is-invalid @enderror"
                                placeholder="Vos observations...">{{ old('observations') }}</textarea>
                            @error('observations')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="perspectives" class="form-label fw-semibold">
                                <i class="bi bi-telescope text-info"></i> Perspectives
                            </label>
                            <textarea name="perspectives" id="perspectives" rows="3"
                                class="form-control @error('perspectives') is-invalid @enderror"
                                placeholder="Perspectives d'évolution...">{{ old('perspectives') }}</textarea>
                            @error('perspectives')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne latérale -->
            <div class="col-lg-4">
                <!-- Échéance -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 p-4">
                        <h5 class="mb-0"><i class="bi bi-calendar-event"></i> Échéance</h5>
                    </div>
                    <div class="card-body p-4">
                        <label for="date_echeance_action" class="form-label fw-semibold">
                            Date d'échéance de l'action
                        </label>
                        <input type="date" name="date_echeance_action" id="date_echeance_action"
                            class="form-control @error('date_echeance_action') is-invalid @enderror"
                            value="{{ old('date_echeance_action') }}">
                        @error('date_echeance_action')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="alert alert-info mt-3 small">
                            <i class="bi bi-info-circle"></i> Définissez une date limite pour le suivi de cette action
                        </div>
                    </div>
                </div>

                <!-- Info promoteur -->
                <div class="card border-0 shadow-sm mb-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <div class="card-body p-4">
                        <h6 class="mb-3"><i class="bi bi-person-badge"></i> Informations promoteur</h6>
                        <div class="mb-2">
                            <small class="opacity-75">Nom</small>
                            <div class="fw-bold">{{ $promoteur->nom }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="opacity-75">Email</small>
                            <div class="fw-bold small">{{ $promoteur->email }}</div>
                        </div>
                        <div class="mb-2">
                            <small class="opacity-75">Téléphone</small>
                            <div class="fw-bold">{{ $promoteur->telephone }}</div>
                        </div>
                        <div>
                            <small class="opacity-75">Projet</small>
                            <div class="fw-bold">{{ $promoteur->projet }}</div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle"></i> Enregistrer l'action
                            </button>
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $promoteur->id) : route('promoteurs.show', $promoteur->id) }}"
                                class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entrepriseActive = document.querySelector('input[name="entreprise_active"]:checked');
        const sectionInactivite = document.getElementById('section_inactivite');
        const chiffreAffaires = document.getElementById('chiffre_affaires');

        function toggleFields() {
            const isActive = document.querySelector('input[name="entreprise_active"]:checked')?.value === '1';

            if (!isActive) {
                sectionInactivite.style.display = 'block';
                chiffreAffaires.disabled = true;
                chiffreAffaires.value = '';
                chiffreAffaires.closest('.col-md-4').classList.add('opacity-50');
            } else {
                sectionInactivite.style.display = 'none';
                chiffreAffaires.disabled = false;
                chiffreAffaires.closest('.col-md-4').classList.remove('opacity-50');
            }
        }

        document.querySelectorAll('input[name="entreprise_active"]').forEach(radio => {
            radio.addEventListener('change', toggleFields);
        });

        toggleFields(); // Initialisation
    });
</script>
@endsection