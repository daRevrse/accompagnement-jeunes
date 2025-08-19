


<div>
    <input type="text" wire:model="search" class="form-control mb-4" placeholder="Rechercher un promoteur par nom...">

    @if($promoteurs->isEmpty())
        <div class="alert alert-info">
            Aucun promoteur trouvé.
        </div>
    @else
        <div class="table-responsive mt-4">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Nom</th>
                        <th scope="col">Projet</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($promoteurs as $promoteur)
                        <tr>
                            <td>{{ $promoteur->nom }}</td>
                            <td>{{ $promoteur->projet }}</td>
                            <td class="text-center">
                                <a href="{{ route('promoteurs.show', $promoteur->id) }}" class="btn btn-sm btn-primary">
                                    📄 Détails
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
