<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl fw-bold">📊 Tableau de bord RH</h2>
    </x-slot>

    <div class="py-4 container">
        {{-- Filtres --}}
        <form method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">Nom</label>
                <input type="text" name="nom" value="{{ request('nom') }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">Entreprise active ?</label>
                <select name="actif" class="form-select">
                    <option value="">Tous</option>
                    <option value="1" {{ request('actif') === '1' ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ request('actif') === '0' ? 'selected' : '' }}>Non</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary">Filtrer</button>
            </div>
        </form>

        {{-- Tableau promoteurs --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Projet</th>
                        <th>Dernière action</th>
                        <th>Entreprise active</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promoteurs as $promoteur)
                        @php
                            $lastAction = $promoteur->actions->first();
                        @endphp
                        <tr>
                            <td>{{ $promoteur->user->name }}</td>
                            <td>{{ $promoteur->projet }}</td>
                            <td>
                                {{ $lastAction ? \Carbon\Carbon::parse($lastAction->date_action)->format('d/m/Y') : '—' }}
                            </td>
                            <td>
                                {{ $lastAction ? ($lastAction->entreprise_active ? '✅ Oui' : '❌ Non') : '—' }}
                            </td>
                            <td>
                                <a href="{{ route('rh.promoteurs.show', $promoteur) }}" class="btn btn-sm btn-outline-primary">
                                    👁️ Voir
                                </a>
                                <a href="{{ route('actions.create', $promoteur) }}" class="btn btn-sm btn-outline-success">
                                    ➕ Action
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-3">
            {{ $promoteurs->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
