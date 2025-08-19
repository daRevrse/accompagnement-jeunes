<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Action;
use App\Models\Promoteur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function dashboard()
    {
        // OPTIMISATION: Utiliser des requêtes agrégées plutôt que count()
        $stats = DB::table('promoteurs')->selectRaw('
            COUNT(*) as nb_promoteurs
        ')->first();

        $actionStats = DB::table('actions')->selectRaw('
            COUNT(*) as nb_actions,
            SUM(chiffre_affaires) as total_chiffre_affaires,
            SUM(CASE WHEN entreprise_active = 1 THEN 1 ELSE 0 END) as actives,
            SUM(CASE WHEN entreprise_active = 0 THEN 1 ELSE 0 END) as inactives
        ')->first();

        // Actions par mois (optimisé)
        $actionsParMois = DB::table('actions')
            ->selectRaw("DATE_FORMAT(date_action, '%Y-%m') as mois, COUNT(*) as total")
            ->where('date_action', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('mois')
            ->orderBy('mois')
            ->get()
            ->pluck('total', 'mois');

        // Préparer les données pour le graphique
        $moisLabels = [];
        $moisData = [];

        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $moisKey = $date->format('Y-m');
            $moisLabels[] = $date->locale('fr_FR')->isoFormat('MMMM YYYY');
            $moisData[] = $actionsParMois->get($moisKey, 0);
        }

        return view('admin.dashboard', [
            'nbPromoteurs' => $stats->nb_promoteurs,
            'nbActions' => $actionStats->nb_actions,
            'totalChiffreAffaires' => $actionStats->total_chiffre_affaires ?? 0,
            'actives' => $actionStats->actives,
            'inactives' => $actionStats->inactives,
            'moisLabels' => $moisLabels,
            'moisData' => $moisData,
        ]);
    }
}
