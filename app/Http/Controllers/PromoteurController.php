<?php
// app/Http/Controllers/PromoteurController.php - VERSION OPTIMISÉE

namespace App\Http\Controllers;

use App\Models\Promoteur;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PromoteurController extends Controller
{
    public function create()
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.promoteurs.create');
        }
        return view('promoteurs.create');
    }

    public function index(Request $request): View
    {
        // OPTIMISATION: Utiliser select() pour limiter les colonnes
        $query = Promoteur::select('id', 'nom', 'email', 'projet', 'date_entree_accompagnement', 'created_at')
            ->with(['actions' => function ($query) {
                $query->select('id', 'promoteur_id', 'date_action', 'entreprise_active', 'chiffre_affaires')
                    ->latest('date_action')
                    ->limit(1); // Seulement la dernière action
            }]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('projet', 'like', '%' . $search . '%');
            });
        }

        // IMPORTANT: Paginer pour limiter la mémoire
        $promoteurs = $query->paginate(10)->withQueryString();

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.promoteurs.index', compact('promoteurs'));
        }
        return view('promoteurs.index', compact('promoteurs'));
    }

    public function show(Promoteur $promoteur): View
    {
        // OPTIMISATION: Charger seulement les colonnes nécessaires
        $promoteur->load(['actions' => function ($query) {
            $query->select('id', 'promoteur_id', 'date_action', 'entreprise_active', 'chiffre_affaires', 'type_suivi', 'created_by')
                ->with(['createdBy:id,name'])
                ->latest('date_action');
        }]);

        // Paginer les actions pour éviter de charger toutes en mémoire
        $actions = $promoteur->actions()
            ->select('id', 'promoteur_id', 'date_action', 'entreprise_active', 'chiffre_affaires', 'type_suivi', 'nombre_emplois', 'date_echeance_action', 'created_by')
            ->with(['createdBy:id,name'])
            ->latest('date_action')
            ->paginate(10);

        // Calculer les stats de manière optimisée
        $stats = [
            'total_actions' => $promoteur->actions()->count(),
            'ca_total' => $promoteur->actions()->sum('chiffre_affaires'),
            'ca_moyen' => $promoteur->actions()->avg('chiffre_affaires'),
            'derniere_action' => $promoteur->actions()
                ->select('date_action', 'entreprise_active')
                ->latest('date_action')
                ->first(),
        ];

        $stats['entreprise_active'] = $stats['derniere_action']?->entreprise_active;

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.promoteurs.show', compact('promoteur', 'actions', 'stats'));
        }
        return view('promoteurs.show', compact('promoteur', 'actions', 'stats'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:promoteurs,email',
            'telephone' => 'required|string|max:20',
            'projet' => 'required|string|max:255',
            'date_entree_accompagnement' => 'nullable|date',
        ]);

        $promoteur = Promoteur::create($validated);

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()
                ->route('admin.promoteurs.show', $promoteur)
                ->with('success', 'Promoteur créé avec succès.');
        }
        return redirect()
            ->route('promoteurs.show', $promoteur)
            ->with('success', 'Promoteur créé avec succès.');
    }

    // Affiche le formulaire d'édition
    public function edit($id)
    {
        $promoteur = Promoteur::findOrFail($id);

        if (auth()->check() && auth()->user()->role === 'admin') {
            return view('admin.promoteurs.edit', compact('promoteur'));
        }
        return view('promoteurs.edit', compact('promoteur'));
    }

    public function update(Request $request, Promoteur $promoteur): RedirectResponse
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:promoteurs,email,' . $promoteur->id,
            'telephone' => 'required|string|max:20',
            'projet' => 'required|string|max:255',
            'date_entree_accompagnement' => 'nullable|date',
        ]);

        $promoteur->update($validated);

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()
                ->route('admin.promoteurs.show', $promoteur)
                ->with('success', 'Promoteur modifié avec succès.');
        }

        return redirect()
            ->route('promoteurs.show', $promoteur)
            ->with('success', 'Promoteur modifié avec succès.');
    }

    public function destroy(Promoteur $promoteur): RedirectResponse
    {
        // Vérifier le nombre d'actions sans les charger en mémoire
        $actionsCount = $promoteur->actions()->count();

        if ($actionsCount > 0) {
            return back()->with('error', 'Impossible de supprimer un promoteur ayant des actions enregistrées.');
        }

        $promoteur->delete();

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()
                ->route('admin.promoteurs.index')
                ->with('success', 'Promoteur supprimé avec succès.');
        }

        return redirect()
            ->route('promoteurs.index')
            ->with('success', 'Promoteur supprimé avec succès.');
    }
}
