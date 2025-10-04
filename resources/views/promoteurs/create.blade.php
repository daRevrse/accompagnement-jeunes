@extends(auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- En-tête -->
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="bi bi-person-plus-fill" style="font-size: 4rem; color: #667eea;"></i>
                </div>
                <h1 class="mb-2">Nouveau promoteur</h1>
                <p class="text-muted">Enregistrez les informations du promoteur</p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form method="POST" action="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.store') : route('promoteurs.store') }}">
                        @csrf

                        <!-- Informations personnelles -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-person"></i> Informations personnelles
                            </h5>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nom" class="form-label fw-semibold">
                                        Nom complet <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-person-fill text-primary"></i>
                                        </span>
                                        <input type="text" name="nom" id="nom"
                                            class="form-control border-start-0 @error('nom') is-invalid @enderror"
                                            value="{{ old('nom') }}"
                                            placeholder="Ex: Jean Dupont"
                                            required>
                                    </div>
                                    @error('nom')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="telephone" class="form-label fw-semibold">
                                        Téléphone <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="bi bi-telephone-fill text-success"></i>
                                        </span>
                                        <input type="tel" name="telephone" id="telephone"
                                            class="form-control border-start-0 @error('telephone') is-invalid @enderror"
                                            value="{{ old('telephone') }}"
                                            placeholder="Ex: +228 XX XX XX XX"
                                            required>
                                    </div>
                                    @error('telephone')
                                    <div class="text-danger small mt-1">
                                        <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-3">
                                <label for="email" class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope-fill text-info"></i>
                                    </span>
                                    <input type="email" name="email" id="email"
                                        class="form-control border-start-0 @error('email') is-invalid @enderror"
                                        value="{{ old('email') }}"
                                        placeholder="exemple@email.com"
                                        required>
                                </div>
                                @error('email')
                                <div class="text-danger small mt-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Informations du projet -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">
                                <i class="bi bi-briefcase"></i> Informations du projet
                            </h5>

                            <div class="mb-3">
                                <label for="projet" class="form-label fw-semibold">
                                    Nom du projet <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-briefcase-fill text-warning"></i>
                                    </span>
                                    <input type="text" name="projet" id="projet"
                                        class="form-control border-start-0 @error('projet') is-invalid @enderror"
                                        value="{{ old('projet') }}"
                                        placeholder="Ex: Startup Tech Innovation"
                                        required>
                                </div>
                                @error('projet')
                                <div class="text-danger small mt-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div>
                                <label for="date_entree_accompagnement" class="form-label fw-semibold">
                                    Date d'entrée en accompagnement
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-calendar-check-fill text-danger"></i>
                                    </span>
                                    <input type="date" name="date_entree_accompagnement" id="date_entree_accompagnement"
                                        class="form-control border-start-0 @error('date_entree_accompagnement') is-invalid @enderror"
                                        value="{{ old('date_entree_accompagnement') }}">
                                </div>
                                @error('date_entree_accompagnement')
                                <div class="text-danger small mt-1">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="d-flex justify-content-end gap-3 mt-4 pt-3 border-top">
                            <a href="{{ auth()->user()->role === 'admin' ? route('admin.promoteurs.index') : route('promoteurs.index') }}"
                                class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle"></i> Enregistrer le promoteur
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Aide -->
            <div class="alert alert-info border-0 shadow-sm mt-4">
                <div class="d-flex">
                    <div class="me-3">
                        <i class="bi bi-info-circle-fill" style="font-size: 1.5rem;"></i>
                    </div>
                    <div>
                        <h6 class="alert-heading">Informations importantes</h6>
                        <ul class="mb-0 small">
                            <li>Les champs marqués d'un <span class="text-danger">*</span> sont obligatoires</li>
                            <li>L'email doit être unique dans le système</li>
                            <li>Vous pourrez ajouter des actions de suivi après la création</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection