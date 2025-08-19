<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Promoteur;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionController extends Controller
{
    public function index(Request $request)
    {
        $query = Action::with('promoteur');

        if ($request->filled('promoteur_id')) {
            $query->where('promoteur_id', $request->promoteur_id);
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_action', [$request->date_debut, $request->date_fin]);
        }

        if ($request->filled('entreprise_active')) {
            $query->where('entreprise_active', $request->entreprise_active);
        }

        $actions = $query->latest()->paginate(15)->withQueryString();
        $promoteurs = \App\Models\Promoteur::all();

        return view('admin.actions.index', compact('actions', 'promoteurs'));
    }

    // Affiche le formulaire de création
    public function create($id)
    {
        $promoteur = Promoteur::findOrFail($id);
        return view('actions.create', compact('promoteur'));
    }

    // Enregistre une nouvelle action
    public function store(Request $request, $promoteurId)
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
        $validated['created_by'] = Auth::id();

        Action::create($validated);

        return redirect()->route('promoteurs.show', $promoteurId)
            ->with('success', 'L\'action a été ajoutée avec succès.');
    }

    // Affiche le détail d'une action
    public function show($id)
    {
        $action = Action::findOrFail($id);
        return view('actions.show', compact('action'));
    }

    public function exportActionsPdf(Request $request)
    {
        $query = Action::with('promoteur');

        if ($request->filled('promoteur_id')) {
            $query->where('promoteur_id', $request->promoteur_id);
        }

        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('date_action', [$request->date_debut, $request->date_fin]);
        }

        if ($request->filled('entreprise_active')) {
            $query->where('entreprise_active', $request->entreprise_active);
        }

        $actions = $query->get();

        $pdf = Pdf::loadView('exports.actions_pdf', compact('actions'));
        return $pdf->download('actions.pdf');
    }
}
