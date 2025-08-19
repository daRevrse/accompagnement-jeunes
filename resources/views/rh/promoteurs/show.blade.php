<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Fiche Promoteur</h2>
    </x-slot>

    <div class="py-4 space-y-6">
        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-bold mb-2">Informations générales</h3>
            <p><strong>Nom :</strong> {{ $promoteur->user->name }}</p>
            <p><strong>Email :</strong> {{ $promoteur->user->email }}</p>
            <p><strong>Projet :</strong> {{ $promoteur->projet }}</p>
        </div>

        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-bold mb-2">Historique des actions</h3>
            @if ($promoteur->actions->isEmpty())
            <p>Aucune action pour l’instant.</p>
            @else
            <table class="w-full text-left border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">Date</th>
                        <th class="p-2 border">CA</th>
                        <th class="p-2 border">Actif ?</th>
                        <th class="p-2 border">Investissements</th>
                        <th class="p-2 border">Perspectives</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promoteur->actions as $action)
                    <tr>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($action->date_action)->format('d/m/Y') }}</td>
                        <td class="p-2 border">{{ $action->chiffre_affaires ?? '—' }}</td>
                        <td class="p-2 border">{{ $action->entreprise_active ? '✅ Oui' : '❌ Non' }}</td>
                        <td class="p-2 border">{{ $action->nouveaux_investissements }}</td>
                        <td class="p-2 border">{{ $action->perspectives }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</x-app-layout>