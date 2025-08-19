<?php

namespace App\Http\Controllers;

use App\Models\Action;
use Illuminate\Http\Request;
use App\Models\Promoteur;

class RhController extends Controller
{
    //

    public function index()
    {
        $nbPromoteurs = Promoteur::count();
        $nbActions = Action::count();

        return view('dashboard', compact('nbPromoteurs', 'nbActions'));
    }

    public function dashboard(Request $request)
    {
        $query = Promoteur::with(['user', 'actions' => fn($q) => $q->latest()]);

        // Filtres
        if ($request->filled('nom')) {
            $query->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', '%' . $request->nom . '%')
            );
        }

        if ($request->filled('actif')) {
            $query->whereHas(
                'actions',
                fn($q) =>
                $q->where('entreprise_active', $request->actif === '1')
            );
        }

        $promoteurs = $query->paginate(10);

        return view('rh.dashboard', compact('promoteurs'));
    }

    public function showPromoteur($id)
    {
        $promoteur = Promoteur::with(['user', 'actions' => fn($q) => $q->latest()])->findOrFail($id);
        return view('rh.promoteurs.show', compact('promoteur'));
    }

    public function stats()
    {
        $totalPromoteurs = Promoteur::count();
        $totalActions = Action::count();
        $actifs = Action::where('entreprise_active', 1)->count();
        $inactifs = Action::where('entreprise_active', 0)->count();
        $moyenneCA = Action::avg('chiffre_affaires');

        return view('rh.stats', compact(
            'totalPromoteurs',
            'totalActions',
            'actifs',
            'inactifs',
            'moyenneCA'
        ));
    }
}
