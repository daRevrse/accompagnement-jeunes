@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">➕ Nouvelle action pour <strong>{{ $promoteur->nom }}</strong></h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('actions.store', $promoteur->id) }}">
                @csrf

                <!-- 📅 Date du suivi -->
                <div class="mb-3">
                    <label class="form-label">📅 Date du suivi <span class="text-danger">*</span></label>
                    <input type="date" name="date_action" class="form-control @error('date_action') is-invalid @enderror"
                        required value="{{ old('date_action', date('Y-m-d')) }}">
                    @error('date_action')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 🔭 Type de suivi -->
                <div class="mb-3">
                    <label class="form-label">🔭 Type de suivi</label>
                    <select name="type_suivi" class="form-select @error('type_suivi') is-invalid @enderror">
                        <option value="">-- Sélectionner --</option>
                        <option value="physique" {{ old('type_suivi') == 'physique' ? 'selected' : '' }}>Physique</option>
                        <option value="téléphonique" {{ old('type_suivi') == 'téléphonique' ? 'selected' : '' }}>Téléphonique</option>
                        <option value="email" {{ old('type_suivi') == 'email' ? 'selected' : '' }}>Email</option>
                    </select>
                    @error('type_suivi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 🏢 Entreprise en activité -->
                <div class="mb-3">
                    <label class="form-label">🏢 Entreprise en activité <span class="text-danger">*</span></label>
                    <select name="entreprise_active" id="entreprise_active" class="form-select @error('entreprise_active') is-invalid @enderror" required>
                        <option value="1" {{ old('entreprise_active', '1') == '1' ? 'selected' : '' }}>Oui</option>
                        <option value="0" {{ old('entreprise_active') == '0' ? 'selected' : '' }}>Non</option>
                    </select>
                    @error('entreprise_active')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Section conditionnelle pour inactivité -->
                <div id="section_inactivite" style="display: none;">
                    <div class="mb-3">
                        <label class="form-label">❓ Raison de l'inactivité</label>
                        <textarea name="raison_inactivite" class="form-control">{{ old('raison_inactivite') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">⚠️ Arrêt de l'activité</label>
                        <select name="arret_activite" class="form-select">
                            <option value="">-- Sélectionner --</option>
                            <option value="provisoire" {{ old('arret_activite') == 'provisoire' ? 'selected' : '' }}>Provisoire</option>
                            <option value="definitif" {{ old('arret_activite') == 'definitif' ? 'selected' : '' }}>Définitif</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <!-- 💰 Chiffre d'affaires -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">💰 Chiffre d'affaires mensuel (FCFA)</label>
                        <input type="number" step="0.01" name="chiffre_affaires" id="chiffre_affaires"
                            class="form-control @error('chiffre_affaires') is-invalid @enderror"
                            value="{{ old('chiffre_affaires') }}">
                        @error('chiffre_affaires')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 💸 Charges -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">💸 Charges mensuelles (FCFA)</label>
                        <input type="number" step="0.01" name="charge" class="form-control @error('charge') is-invalid @enderror"
                            value="{{ old('charge') }}">
                        @error('charge')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- 👥 Emplois -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">👥 Nombre d'emplois</label>
                        <input type="number" name="nombre_emplois" class="form-control @error('nombre_emplois') is-invalid @enderror"
                            value="{{ old('nombre_emplois') }}">
                        @error('nombre_emplois')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- 📈 Investissements -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">📈 Nouveaux investissements (FCFA)</label>
                        <input type="number" step="0.01" name="investissements" class="form-control @error('investissements') is-invalid @enderror"
                            value="{{ old('investissements') }}">
                        @error('investissements')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 💳 Situation crédit -->
                <div class="mb-3">
                    <label class="form-label">💳 Situation du crédit</label>
                    <input type="text" name="situation_credit" class="form-control @error('situation_credit') is-invalid @enderror"
                        value="{{ old('situation_credit') }}">
                    @error('situation_credit')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ❓ Difficultés -->
                <div class="mb-3">
                    <label class="form-label">❓ Difficultés rencontrées</label>
                    <textarea name="difficultes" rows="3" class="form-control @error('difficultes') is-invalid @enderror">{{ old('difficultes') }}</textarea>
                    @error('difficultes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ Solutions -->
                <div class="mb-3">
                    <label class="form-label">✅ Solutions proposées</label>
                    <textarea name="solutions" rows="3" class="form-control @error('solutions') is-invalid @enderror">{{ old('solutions') }}</textarea>
                    @error('solutions')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 🏢 Action FAIEJ -->
                <div class="mb-3">
                    <label class="form-label">🏢 Action du FAIEJ</label>
                    <textarea name="action_faiej" rows="3" class="form-control @error('action_faiej') is-invalid @enderror">{{ old('action_faiej') }}</textarea>
                    @error('action_faiej')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- 📅 Échéance -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">📅 Date d'échéance de l'action</label>
                        <input type="date" name="date_echeance_action" class="form-control @error('date_echeance_action') is-invalid @enderror"
                            value="{{ old('date_echeance_action') }}">
                        @error('date_echeance_action')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- ⏳ Délais -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">⏳ Délais (en jours) <span class="text-danger">*</span></label>
                        <input type="number" name="delais" class="form-control @error('delais') is-invalid @enderror"
                            required value="{{ old('delais') }}">
                        @error('delais')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- 📝 Observations -->
                <div class="mb-3">
                    <label class="form-label">📝 Observations</label>
                    <textarea name="observations" rows="3" class="form-control @error('observations') is-invalid @enderror">{{ old('observations') }}</textarea>
                    @error('observations')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- 🔭 Perspectives -->
                <div class="mb-3">
                    <label class="form-label">🔭 Perspectives</label>
                    <textarea name="perspectives" rows="3" class="form-control @error('perspectives') is-invalid @enderror">{{ old('perspectives') }}</textarea>
                    @error('perspectives')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- ✅ Boutons -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $promoteur->id) : route('promoteurs.show', $promoteur->id) }}"
                        class="btn btn-secondary">
                        ↩️ Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 Enregistrer l'action
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const entrepriseActive = document.getElementById('entreprise_active');
        const sectionInactivite = document.getElementById('section_inactivite');
        const chiffreAffaires = document.getElementById('chiffre_affaires');

        function toggleFields() {
            if (entrepriseActive.value === '0') {
                sectionInactivite.style.display = 'block';
                chiffreAffaires.disabled = true;
                chiffreAffaires.value = '';
            } else {
                sectionInactivite.style.display = 'none';
                chiffreAffaires.disabled = false;
            }
        }

        entrepriseActive.addEventListener('change', toggleFields);
        toggleFields(); // Initialisation
    });
</script>
@endsection