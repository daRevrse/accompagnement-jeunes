<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Promoteur;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ActionController extends Controller
{
    /**
     * Liste des actions avec filtres (réservé admin)
     */
    public function index(Request $request): View
    {
        $query = Action::with('promoteur:id,nom,email,projet');

        // Filtres
        if ($request->filled('promoteur_id')) {
            $query->where('promoteur_id', $request->promoteur_id);
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_action', [$request->date_debut, $request->date_fin]);
        }

        if ($request->filled('entreprise_active')) {
            $query->where('entreprise_active', $request->entreprise_active);
        }

        $actions = $query->latest('date_action')->paginate(15)->withQueryString();
        $promoteurs = Promoteur::select('id', 'nom')->orderBy('nom')->get();

        return view('actions.index', compact('actions', 'promoteurs'));
    }

    /**
     * Affiche le formulaire de création d'action
     */
    public function create($promoteurId): View
    {
        $promoteur = Promoteur::findOrFail($promoteurId);
        return view('actions.create', compact('promoteur'));
    }

    /**
     * Enregistre une nouvelle action
     */
    public function store(Request $request, $promoteurId): RedirectResponse
    {
        $validated = $request->validate([
            'date_action' => 'required|date',
            'chiffre_affaires' => 'nullable|numeric',
            'charge' => 'nullable|numeric',
            'nombre_emplois' => 'nullable|integer',
            'entreprise_active' => 'required|boolean',
            'type_suivi' => 'nullable|string',
            'raison_inactivite' => 'nullable|string',
            'arret_activite' => 'nullable|in:provisoire,definitif',
            'investissements' => 'nullable|numeric',
            'situation_credit' => 'nullable|string',
            'difficultes' => 'nullable|string',
            'solutions' => 'nullable|string',
            'action_faiej' => 'nullable|string',
            'date_echeance_action' => 'nullable|date',
            'observations' => 'nullable|string',
            'perspectives' => 'nullable|string',
            'commentaire' => 'nullable|string',
            'actions_prevues' => 'nullable|string',
            'delais' => 'required|integer',
        ]);

        $validated['promoteur_id'] = $promoteurId;
        $validated['created_by'] = auth()->id();

        Action::create($validated);

        $route = auth()->user()->role === 'admin'
            ? 'admin.promoteurs.show'
            : 'promoteurs.show';

        return redirect()
            ->route($route, $promoteurId)
            ->with('success', 'Action enregistrée avec succès.');
    }

    /**
     * Affiche le détail d'une action
     */
    public function show($actionId): View
    {
        $action = Action::with(['promoteur', 'createdBy'])->findOrFail($actionId);
        return view('actions.show', compact('action'));
    }

    /**
     * Export PDF des actions (admin uniquement)
     */
    public function exportActionsPdf(Request $request)
    {
        $query = Action::with('promoteur');

        // Appliquer les mêmes filtres que l'index
        if ($request->filled('promoteur_id')) {
            $query->where('promoteur_id', $request->promoteur_id);
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_action', [$request->date_debut, $request->date_fin]);
        }

        if ($request->filled('entreprise_active')) {
            $query->where('entreprise_active', $request->entreprise_active);
        }

        $actions = $query->latest('date_action')->get();

        $pdf = Pdf::loadView('exports.actions_pdf', compact('actions'));
        return $pdf->download('actions_' . date('Y-m-d') . '.pdf');
    }
}
