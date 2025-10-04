@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Modifier le promoteur</h1>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.update', $promoteur) : route('promoteurs.update', $promoteur) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom du promoteur <span class="text-danger">*</span></label>
                        <input type="text" name="nom" id="nom" class="form-control @error('nom') is-invalid @enderror"
                            value="{{ old('nom', $promoteur->nom) }}" required>
                        @error('nom')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $promoteur->email) }}" required>
                        @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="telephone" class="form-label">Téléphone <span class="text-danger">*</span></label>
                        <input type="tel" name="telephone" id="telephone" class="form-control @error('telephone') is-invalid @enderror"
                            value="{{ old('telephone', $promoteur->telephone) }}" required>
                        @error('telephone')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="projet" class="form-label">Nom du projet <span class="text-danger">*</span></label>
                        <input type="text" name="projet" id="projet" class="form-control @error('projet') is-invalid @enderror"
                            value="{{ old('projet', $promoteur->projet) }}" required>
                        @error('projet')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="date_entree_accompagnement" class="form-label">Date d'entrée en accompagnement</label>
                    <input type="date" name="date_entree_accompagnement" id="date_entree_accompagnement"
                        class="form-control @error('date_entree_accompagnement') is-invalid @enderror"
                        value="{{ old('date_entree_accompagnement', $promoteur->date_entree_accompagnement?->format('Y-m-d')) }}">
                    @error('date_entree_accompagnement')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.show', $promoteur) : route('promoteurs.show', $promoteur) }}"
                        class="btn btn-secondary">
                        ↩️ Annuler
                    </a>
                    <button type="submit" class="btn btn-primary">
                        💾 Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection