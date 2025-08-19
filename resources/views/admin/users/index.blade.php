@extends('layouts.admin')

@section('title', 'Utilisateurs')

@section('content')
<h1 class="mb-4">👥 Utilisateurs</h1>

<form method="GET" action="{{ route('admin.users.index') }}" class="mb-3 d-flex">
    <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Rechercher par nom ou email...">
    <button class="btn btn-outline-primary">🔍 Rechercher</button>
</form>

<a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-success mb-3">➕ Nouvel utilisateur</a>

<div class="mb-3">
    <a href="{{ route('admin.promoteurs.export.excel') }}" class="btn btn-sm btn-outline-success">⬇️ Export Excel</a>
    <a href="{{ route('admin.promoteurs.export.pdf') }}" class="btn btn-sm btn-outline-danger">⬇️ Export PDF</a>
</div>


@if($users->isEmpty())
<div class="alert alert-info">Aucun utilisateur trouvé.</div>
@else
<table class="table table-striped">
    <thead class="table-dark">
        <tr>
            <th>Nom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th class="text-end">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->nom }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ ucfirst($user->role) }}</td>
            <td class="text-end">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-outline-primary">✏️ Modifier</a>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline"
                    onsubmit="return confirm('Confirmer la suppression ?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">🗑️ Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $users->links() }}
@endif
@endsection