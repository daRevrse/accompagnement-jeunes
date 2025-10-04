@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<div class="container">
    <h1 class="mb-4">👥 Gestion des utilisateurs</h1>

    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text" name="search" value="{{ request('search') }}"
                    class="form-control" placeholder="Rechercher par nom ou email...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-outline-primary w-100">🔍 Rechercher</button>
            </div>
        </div>
    </form>

    <div class="mb-3 d-flex gap-2">
        <a href="{{ route('admin.users.create') }}" class="btn btn-success">
            ➕ Nouvel utilisateur
        </a>
        <a href="{{ route('admin.users.export.excel') }}" class="btn btn-outline-success">
            ⬇️ Export Excel
        </a>
        <a href="{{ route('admin.users.export.pdf') }}" class="btn btn-outline-danger">
            ⬇️ Export PDF
        </a>
    </div>

    @if($users->isEmpty())
    <div class="alert alert-info">Aucun utilisateur trouvé.</div>
    @else
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date de création</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge {{ $user->role === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                                    ✏️ Modifier
                                </a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Confirmer la suppression de {{ $user->name }} ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger">
                                        🗑️ Supprimer
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="card-footer">
            {{ $users->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
@endsection