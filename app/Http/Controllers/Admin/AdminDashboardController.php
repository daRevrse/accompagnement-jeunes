<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Promoteur;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    //
    public function index()
    {
        $nbPromoteurs = Promoteur::count();
        $nbActions = Action::count();
        $totalChiffreAffaires = Action::sum('chiffre_affaires');

        // Actions par mois (12 derniers mois)
        $actionsParMois = Action::selectRaw('MONTH(date_action) as mois, COUNT(*) as total')
            ->where('date_action', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('mois')
            ->pluck('total', 'mois');

        $moisLabels = [];
        $moisData = [];

        foreach (range(1, 12) as $m) {
            $moisLabels[] = Carbon::create()->month($m)->locale('fr_FR')->isoFormat('MMMM');
            $moisData[] = $actionsParMois->get($m, 0);
        }

        // Répartition entreprise active / inactive
        $actives = Action::where('entreprise_active', true)->count();
        $inactives = Action::where('entreprise_active', false)->count();

        return view('admin.dashboard', compact(
            'nbPromoteurs',
            'nbActions',
            'totalChiffreAffaires',
            'moisLabels',
            'moisData',
            'actives',
            'inactives'
        ));
    }

    public function dashboard()
    {
        $nbPromoteurs = Promoteur::count();
        $nbActions = Action::count();
        $totalChiffreAffaires = Action::sum('chiffre_affaires');

        // Camembert
        $actives = Action::where('entreprise_active', true)->count();
        $inactives = Action::where('entreprise_active', false)->count();

        // Ligne par mois
        $actionsParMois = Action::selectRaw("DATE_FORMAT(date_action, '%Y-%m') as mois, COUNT(*) as total")
            ->groupBy('mois')
            ->orderBy('mois')
            ->get();

        $moisLabels = $actionsParMois->pluck('mois');
        $moisData = $actionsParMois->pluck('total');

        return view('admin.dashboard', compact(
            'nbPromoteurs',
            'nbActions',
            'totalChiffreAffaires',
            'actives',
            'inactives',
            'moisLabels',
            'moisData'
        ));
    }
}
