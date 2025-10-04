<?php

namespace App\Http\Controllers;

use App\Models\Promoteur;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PromoteurController extends Controller
{
    /**
     * Affiche la liste des promoteurs avec recherche et pagination
     */
    public function index(Request $request): View
    {
        $query = Promoteur::select('id', 'nom', 'email', 'projet', 'telephone', 'date_entree_accompagnement', 'created_at')
            ->with(['actions' => function ($q) {
                $q->select('id', 'promoteur_id', 'date_action', 'entreprise_active', 'chiffre_affaires')
                    ->latest('date_action')
                    ->limit(1);
            }]);

        // Recherche
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('projet', 'like', '%' . $search . '%');
            });
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            if ($request->statut === 'actif') {
                $query->whereHas('actions', function ($q) {
                    $q->where('entreprise_active', true)
                        ->whereRaw('date_action = (SELECT MAX(date_action) FROM actions WHERE actions.promoteur_id = promoteurs.id)');
                });
            } elseif ($request->statut === 'inactif') {
                $query->whereHas('actions', function ($q) {
                    $q->where('entreprise_active', false)
                        ->whereRaw('date_action = (SELECT MAX(date_action) FROM actions WHERE actions.promoteur_id = promoteurs.id)');
                });
            }
        }

        $promoteurs = $query->paginate(10)->withQueryString();

        return view('promoteurs.index', compact('promoteurs'));
    }

    /**
     * Affiche le formulaire de création
     */
    public function create(): View
    {
        return view('promoteurs.create');
    }

    /**
     * Enregistre un nouveau promoteur
     */
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

        $route = auth()->user()->role === 'admin'
            ? 'admin.promoteurs.show'
            : 'promoteurs.show';

        return redirect()
            ->route($route, $promoteur)
            ->with('success', 'Promoteur créé avec succès.');
    }

    /**
     * Affiche les détails d'un promoteur
     */
    public function show(Promoteur $promoteur): View
    {
        // Paginer les actions
        $actions = $promoteur->actions()
            ->select('id', 'promoteur_id', 'date_action', 'entreprise_active', 'chiffre_affaires', 'type_suivi', 'nombre_emplois', 'date_echeance_action', 'created_by')
            ->with(['createdBy:id,name'])
            ->latest('date_action')
            ->paginate(10);

        // Calculer les statistiques
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

        return view('promoteurs.show', compact('promoteur', 'actions', 'stats'));
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit(Promoteur $promoteur): View
    {
        return view('promoteurs.edit', compact('promoteur'));
    }

    /**
     * Met à jour un promoteur
     */
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

        $route = auth()->user()->role === 'admin'
            ? 'admin.promoteurs.show'
            : 'promoteurs.show';

        return redirect()
            ->route($route, $promoteur)
            ->with('success', 'Promoteur modifié avec succès.');
    }

    /**
     * Supprime un promoteur
     */
    public function destroy(Promoteur $promoteur): RedirectResponse
    {
        // Vérifier s'il a des actions
        if ($promoteur->actions()->count() > 0) {
            return back()->with('error', 'Impossible de supprimer un promoteur ayant des actions enregistrées.');
        }

        $promoteur->delete();

        $route = auth()->user()->role === 'admin'
            ? 'admin.promoteurs.index'
            : 'promoteurs.index';

        return redirect()
            ->route($route)
            ->with('success', 'Promoteur supprimé avec succès.');
    }
}
