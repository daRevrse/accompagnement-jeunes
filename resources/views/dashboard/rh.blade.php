<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Dashboard RH</h2>
    </x-slot>

    <div class="max-w-6xl mx-auto py-6">
        <h3 class="mb-4 text-lg font-bold">Liste des promoteurs</h3>

        <table class="w-full border text-left">
            <thead>
                <tr>
                    <th class="p-2 border">Nom</th>
                    <th class="p-2 border">Projet</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($promoteurs as $promoteur)
                <tr>
                    <td class="p-2 border">{{ $promoteur->user->name }}</td>
                    <td class="p-2 border">{{ $promoteur->projet }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('actions.create', $promoteur) }}" class="text-blue-600">Ajouter une action</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>