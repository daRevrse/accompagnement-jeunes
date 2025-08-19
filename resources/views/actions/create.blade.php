@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">➕ Nouvelle action pour <strong>{{ $promoteur->nom }}</strong></h1>

    <form method="POST" action="{{ route('actions.store', $promoteur->id) }}">
        @csrf

        <!-- 📅 Date du suivi -->
        <div class="mb-3">
            <label class="form-label">📅 Date du suivi</label>
            <input type="date" name="date_action" class="form-control" required value="{{ old('date_action') }}">
            @error('date_action') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 🔭 Type de suivi -->
        <div class="mb-3">
            <label class="form-label">🔭 Type de suivi</label>
            <select name="type_suivi" class="form-select">
                <option value="">-- Sélectionner --</option>
                <option value="physique" {{ old('type_suivi') == 'physique' ? 'selected' : '' }}>Physique</option>
                <option value="téléphonique" {{ old('type_suivi') == 'téléphonique' ? 'selected' : '' }}>Téléphonique</option>
                <option value="email" {{ old('type_suivi') == 'email' ? 'selected' : '' }}>Email</option>
            </select>
            @error('type_suivi') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 🏢 Entreprise en activité -->
        <div class="mb-3">
            <label class="form-label">🏢 Entreprise en activité</label>
            <select name="entreprise_active" class="form-select">
                <option value="1" {{ old('entreprise_active') == '1' ? 'selected' : '' }}>Oui</option>
                <option value="0" {{ old('entreprise_active') == '0' ? 'selected' : '' }}>Non</option>
            </select>
            @error('entreprise_active') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 💰 Chiffre d'affaires -->
        <div class="mb-3">
            <label class="form-label">💰 Chiffre d'affaires mensuel (en FCFA)</label>
            <input type="number" step="0.01" name="chiffre_affaires" class="form-control" value="{{ old('chiffre_affaires') }}">
            @error('chiffre_affaires') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 💸 Charges -->
        <div class="mb-3">
            <label class="form-label">💸 Charges mensuelles (en FCFA)</label>
            <input type="number" step="0.01" name="charge" class="form-control" value="{{ old('charge') }}">
            @error('charge') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 👥 Emplois -->
        <div class="mb-3">
            <label class="form-label">👥 Nombre d'emplois</label>
            <input type="number" name="nombre_emplois" class="form-control" value="{{ old('nombre_emplois') }}">
            @error('nombre_emplois') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 📈 Investissements -->
        <div class="mb-3">
            <label class="form-label">📈 Nouveaux investissements (en FCFA)</label>
            <input type="number" step="0.01" name="investissements" class="form-control" value="{{ old('investissements') }}">
            @error('investissements') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 💳 Situation crédit -->
        <div class="mb-3">
            <label class="form-label">💳 Situation du crédit</label>
            <input type="text" name="situation_credit" class="form-control" value="{{ old('situation_credit') }}">
            @error('situation_credit') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- ❓ Difficultés -->
        <div class="mb-3">
            <label class="form-label">❓ Difficultés rencontrées</label>
            <textarea name="difficultes" class="form-control">{{ old('difficultes') }}</textarea>
            @error('difficultes') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- ✅ Solutions -->
        <div class="mb-3">
            <label class="form-label">✅ Solutions proposées</label>
            <textarea name="solutions" class="form-control">{{ old('solutions') }}</textarea>
            @error('solutions') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 🏢 Action FAIEJ -->
        <div class="mb-3">
            <label class="form-label">🏢 Action du FAIEJ</label>
            <textarea name="action_faiej" class="form-control">{{ old('action_faiej') }}</textarea>
            @error('action_faiej') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 📅 Échéance -->
        <div class="mb-3">
            <label class="form-label">📅 Date d'échéance de l'action</label>
            <input type="date" name="date_echeance_action" class="form-control" value="{{ old('date_echeance_action') }}">
            @error('date_echeance_action') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 📝 Observations -->
        <div class="mb-3">
            <label class="form-label">📝 Observations</label>
            <textarea name="observations" class="form-control">{{ old('observations') }}</textarea>
            @error('observations') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 🔭 Perspectives -->
        <div class="mb-3">
            <label class="form-label">🔭 Perspectives</label>
            <textarea name="perspectives" class="form-control">{{ old('perspectives') }}</textarea>
            @error('perspectives') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- 🕒 Délais -->
        <div class="mb-3">
            <label class="form-label">⏳ Délais</label>
            <input type="number" name="delais" class="form-control" required value="{{ old('delais') }}">
            @error('delais') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- ✅ Boutons -->
        <button type="submit" class="btn btn-primary">💾 Enregistrer</button>
        <a href="{{ route('promoteurs.show', $promoteur->id) }}" class="btn btn-secondary ms-2">↩️ Retour</a>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const entrepriseActive = document.querySelector('select[name="entreprise_active"]');
    const chiffreAffaires = document.querySelector('input[name="chiffre_affaires"]');

    function toggleChiffreAffaires() {
        if (entrepriseActive.value === '0') {
            chiffreAffaires.disabled = true;
            chiffreAffaires.value = '';
        } else {
            chiffreAffaires.disabled = false;
        }
    }

    entrepriseActive.addEventListener('change', toggleChiffreAffaires);
    toggleChiffreAffaires(); // Initialisation
});
</script>
@endsection
