@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6">➕ Créer un promoteur</h1>

    <form method="POST" action="{{ route('promoteurs.store') }}" class="bg-white p-6 rounded shadow">
        @csrf

        <div class="mb-4">
            <label for="nom" class="block text-sm font-medium text-gray-700">Nom du promoteur</label>
            <input type="text" name="nom" id="nom"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('nom') }}" required>
            @error('nom')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type='email' name="email" id="email"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('email') }}" required>
            @error('email')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="telephone" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
            <input type='tel' name="telephone" id="telephone"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('telephone') }}" required>
            @error('telephone')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="projet" class="block text-sm font-medium text-gray-700">Nom du projet</label>
            <input type="text" name="projet" id="projet"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                value="{{ old('projet') }}" required>
            @error('projet')
            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>


        <div class="mt-6">
            <button type="submit"
                class="w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded hover:bg-blue-700 transition">
                💾 Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection