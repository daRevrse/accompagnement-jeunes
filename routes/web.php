<?php

use App\Exports\ActionsExport;
use App\Exports\PromoteursExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoteurController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\RhController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

// Routes d'authentification Laravel Breeze
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| Routes ADMIN (nécessite authentification + rôle admin)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard admin
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Gestion des utilisateurs
    Route::resource('users', UserController::class)->except(['show']);

    // Gestion des promoteurs (admin)
    Route::resource('promoteurs', PromoteurController::class);

    // Gestion des actions (admin)
    Route::resource('actions', ActionController::class)->only(['index', 'show']);

    // Exports Promoteurs
    Route::get('/promoteurs/export/excel', function () {
        return Excel::download(new PromoteursExport, 'promoteurs.xlsx');
    })->name('promoteurs.export.excel');

    Route::get('/promoteurs/export/pdf', [UserController::class, 'exportPromoteursPdf'])
        ->name('promoteurs.export.pdf');

    // Exports Utilisateurs
    Route::get('/users/export/excel', function () {
        return Excel::download(new \App\Exports\UsersExport, 'utilisateurs.xlsx');
    })->name('users.export.excel');

    Route::get('/users/export/pdf', [UserController::class, 'exportUsersPdf'])
        ->name('users.export.pdf');

    Route::get('/actions/export/excel', function (\Illuminate\Http\Request $request) {
        return Excel::download(new ActionsExport($request->all()), 'actions.xlsx');
    })->name('actions.export.excel');

    Route::get('/actions/export/pdf', [ActionController::class, 'exportActionsPdf'])
        ->name('actions.export.pdf');
});


/*
|--------------------------------------------------------------------------
| Routes UTILISATEURS AUTHENTIFIÉS (RH + Promoteurs)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [RhController::class, 'index'])->name('dashboard');

    // Gestion du profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== PROMOTEURS =====
    Route::resource('promoteurs', PromoteurController::class);

    // ===== ACTIONS =====
    // Création d'action liée à un promoteur
    Route::prefix('promoteurs/{promoteur}')->name('actions.')->group(function () {
        Route::get('/actions/create', [ActionController::class, 'create'])->name('create');
        Route::post('/actions', [ActionController::class, 'store'])->name('store');
    });

    // Affichage d'une action
    Route::get('/actions/{action}', [ActionController::class, 'show'])->name('actions.show');


    // ===== ROUTES RH SPÉCIFIQUES =====
    Route::middleware('role:rh')->prefix('rh')->name('rh.')->group(function () {
        Route::get('/dashboard', [RhController::class, 'dashboard'])->name('dashboard');
        Route::get('/stats', [RhController::class, 'stats'])->name('stats');
        Route::get('/promoteurs/{promoteur}', [RhController::class, 'showPromoteur'])->name('promoteurs.show');
    });
});


/*
|--------------------------------------------------------------------------
| Routes API (optionnel pour AJAX)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {

    // Actions d'un promoteur (AJAX)
    Route::get('/promoteurs/{promoteur}/actions', function (\App\Models\Promoteur $promoteur) {
        return response()->json([
            'actions' => $promoteur->actions()->with('createdBy')->latest('date_action')->get()
        ]);
    })->name('promoteurs.actions');

    // Stats dashboard (AJAX)
    Route::get('/stats/dashboard', function () {
        return response()->json([
            'promoteurs' => \App\Models\Promoteur::count(),
            'actions' => \App\Models\Action::count(),
            'ca_total' => \App\Models\Action::sum('chiffre_affaires'),
            'actives' => \App\Models\Action::actives()->count(),
            'inactives' => \App\Models\Action::inactives()->count(),
        ]);
    })->name('stats.dashboard');
});
