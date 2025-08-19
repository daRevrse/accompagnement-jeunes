<?php

namespace App\Http\Controllers;

use App\Models\Promoteur;
use Illuminate\Http\Request;

class PromoteurController extends Controller
{
    // Affiche le formulaire de création
    public function create()
    {
        return view('promoteurs.create');
    }

    // Enregistre un nouveau promoteur avec validation stricte
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'email' => 'required|email',
            'telephone' => 'required|string',
            'projet' => 'nullable|string',
            'date_entree_accompagnement' => 'nullable|date',
        ]);

        Promoteur::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Promoteur enregistré avec succès.');
    }

    // Affiche la liste des promoteurs
    public function index(Request $request)
    {
        $query = Promoteur::with(['actions' => fn($q) => $q->latest()]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $promoteurs = $query->paginate(10);

        return view('promoteurs.index', compact('promoteurs'));
    }

    // Affiche le détail d'un promoteur
    public function show($id)
    {
        $promoteur = Promoteur::with('actions')->findOrFail($id);
        $actions = $promoteur->actions()->paginate(10);
        return view('promoteurs.show', compact('promoteur', 'actions'));
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $promoteur = Promoteur::findOrFail($id);
        return view('promoteurs.edit', compact('promoteur'));
    }

    // Met à jour les informations du promoteur
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
            'email' => 'required|email',
            'telephone' => 'required|string',
            'projet' => 'nullable|string',
            'date_entree_accompagnement' => 'nullable|date',
        ]);

        $promoteur = Promoteur::findOrFail($id);
        $promoteur->update($request->all());

        return redirect()->route('promoteurs.index')->with('success', 'Promoteur mis à jour avec succès.');
    }

    // Supprime un promoteur
    public function destroy($id)
    {
        $promoteur = Promoteur::findOrFail($id);
        $promoteur->delete();

        return redirect()->route('promoteurs.index')->with('success', 'Promoteur supprimé avec succès.');
    }
}
