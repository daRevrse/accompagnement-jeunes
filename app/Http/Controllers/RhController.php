<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Promoteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RhController extends Controller
{
    /**
     * Dashboard principal RH
     */
    public function index()
    {
        // Statistiques de base
        $nbPromoteurs = Promoteur::count();
        $nbActions = Action::count();

        // Statistiques actives/inactives basées sur la dernière action
        $actionStats = DB::table('actions')
            ->selectRaw('
                SUM(CASE WHEN entreprise_active = 1 THEN 1 ELSE 0 END) as actives,
                SUM(CASE WHEN entreprise_active = 0 THEN 1 ELSE 0 END) as inactives
            ')
            ->whereIn('id', function ($query) {
                $query->selectRaw('MAX(id)')
                    ->from('actions')
                    ->groupBy('promoteur_id');
            })
            ->first();

        $nbActives = $actionStats->actives ?? 0;
        $nbInactives = $actionStats->inactives ?? 0;

        // Derniers promoteurs ajoutés (5 derniers)
        $derniersPromoteurs = Promoteur::latest()
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'nbPromoteurs',
            'nbActions',
            'nbActives',
            'nbInactives',
            'derniersPromoteurs'
        ));
    }

    /**
     * Dashboard RH avec filtres (si nécessaire)
     */
    public function dashboard(Request $request)
    {
        $query = Promoteur::with(['actions' => fn($q) => $q->latest()]);

        // Filtres
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        if ($request->filled('actif')) {
            $query->whereHas(
                'actions',
                fn($q) => $q->where('entreprise_active', $request->actif === '1')
            );
        }

        $promoteurs = $query->paginate(10);

        return view('rh.dashboard', compact('promoteurs'));
    }

    /**
     * Afficher un promoteur
     */
    public function showPromoteur($id)
    {
        $promoteur = Promoteur::with(['actions' => fn($q) => $q->latest()])
            ->findOrFail($id);

        return view('rh.promoteurs.show', compact('promoteur'));
    }

    /**
     * Statistiques RH
     */
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
