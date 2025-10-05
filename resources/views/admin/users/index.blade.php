@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1><i class="bi bi-people-fill"></i> Gestion des utilisateurs</h1>
            <p class="text-muted mb-0">{{ $users->total() }} utilisateur(s) enregistré(s)</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
            <i class="bi bi-plus-circle"></i> Nouvel utilisateur
        </a>
    </div>

    {{-- Formulaire de recherche --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="form-control border-start-0" placeholder="Rechercher par nom ou email...">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Boutons d'export --}}
    <div class="mb-4">
        <a href="{{ route('admin.users.export.excel') }}" class="btn btn-outline-success">
            <i class="bi bi-file-earmark-excel"></i> Export Excel
        </a>
        <a href="{{ route('admin.users.export.pdf') }}" class="btn btn-outline-danger">
            <i class="bi bi-file-earmark-pdf"></i> Export PDF
        </a>
    </div>

    @if($users->count())
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date de création</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                        style="width: 40px; height: 40px; font-size: 1rem;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <strong>{{ $user->name }}</strong>
                                </div>
                            </td>
                            <td>
                                <i class="bi bi-envelope text-muted"></i> {{ $user->email }}
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                <span class="badge bg-danger">
                                    <i class="bi bi-shield-lock-fill"></i> Admin
                                </span>
                                @else
                                <span class="badge bg-primary">
                                    <i class="bi bi-person-badge"></i> RH
                                </span>
                                @endif
                            </td>
                            <td>
                                <i class="bi bi-calendar-check text-muted"></i>
                                {{ $user->created_at->format('d/m/Y') }}
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i> Modifier
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Confirmer la suppression de {{ $user->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Supprimer
                                    </button>
                                </form>
                                @else
                                <button class="btn btn-sm btn-outline-secondary" disabled>
                                    <i class="bi bi-shield-check"></i> Vous
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($users->hasPages())
    <div class="mt-4">
        {{ $users->links() }}
    </div>
    @endif
    @else
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-inbox" style="font-size: 4rem; color: #ccc;"></i>
            </div>
            <h4>Aucun utilisateur trouvé</h4>
            <p class="text-muted">
                {{ request('search') ? 'Aucun résultat pour votre recherche.' : 'Aucun utilisateur enregistré.' }}
            </p>
            @if(!request('search'))
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary mt-3">
                <i class="bi bi-plus-circle"></i> Créer le premier utilisateur
            </a>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection