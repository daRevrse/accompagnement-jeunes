<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">Statistiques générales</h2>
    </x-slot>

    <div class="py-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600">Total promoteurs</h3>
            <p class="text-2xl font-bold">{{ $totalPromoteurs }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600">Total actions</h3>
            <p class="text-2xl font-bold">{{ $totalActions }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600">Entreprises actives</h3>
            <p class="text-2xl font-bold">{{ $actifs }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600">Entreprises inactives</h3>
            <p class="text-2xl font-bold">{{ $inactifs }}</p>
        </div>
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-gray-600">Moyenne CA</h3>
            <p class="text-2xl font-bold">{{ number_format($moyenneCA, 2) }} F</p>
        </div>
    </div>
</x-app-layout>