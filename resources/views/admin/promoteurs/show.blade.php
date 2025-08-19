@extends('layouts.admin')

@section('content')
<!-- <livewire:promoteur-actions :promoteur-id="$promoteur->id" /> -->

<div class="container">
    <h1 class="mb-4">👤 Détail du promoteur : <strong>{{ $promoteur->nom }}</strong></h1>

    <div class="mb-4">
        <p><strong>Email :</strong> {{ $promoteur->email }}</p>
        <p><strong>Téléphone :</strong> {{ $promoteur->telephone }}</p>
        <p><strong>Projet :</strong> {{ $promoteur->projet }}</p>
    </div>

    <hr>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">📝 Actions réalisées</h2>
        <a href="{{ route('actions.create', $promoteur->id) }}" class="btn btn-success">
            ➕ Ajouter une action
        </a>
    </div>

    @if(isset($actions) && $actions->count())
    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>Date</th>
                    <th>Entreprise active</th>
                    <th>Type de suivi</th>
                    <th>Difficultés</th>
                    <th>Actions prévues</th>
                    <th>Délais</th>
                    <th>Statut</th>
                    <th>✔️ Sélection</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($actions as $action)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($action->date_action)->format('d/m/Y') }}</td>
                    <td>
                        <span class="badge {{ $action->entreprise_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $action->entreprise_active ? 'Oui' : 'Non' }}
                        </span>
                    </td>
                    <td>{{ $action->type_suivi ?? '-' }}</td>
                    <td>{{ $action->difficultes ?? '-' }}</td>
                    <td>{{ $action->actions_prevues ?? '-' }}</td>
                    <td>{{ $action->delais ?? '-' }}</td>
                    <td>{{ $action->entreprise_active ? 'Active' : 'Inactive' }}</td>
                    <td>
                        <input type="checkbox" name="actions_checked[]" value="{{ $action->id }}">
                    </td>
                    <td>
                        <a href="{{ route('actions.show', $action->id) }}" class="btn btn-sm btn-info">
                            👁️ Consulter
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $actions->links() }}
    </div>
    @else
    <div class="alert alert-info">Aucune action enregistrée pour ce promoteur.</div>
    @endif
</div>
@endsection