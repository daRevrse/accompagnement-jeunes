<?php

use App\Exports\ActionsExport;
use App\Exports\PromoteursExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoteurController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\RhController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Maatwebsite\Excel\Facades\Excel;

// Page d'accueil
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

// Routes d'authentification (générées par Breeze)
// require __DIR__ . '/auth.php';
// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Enregistrement du formulaire
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// =================
// ROUTES ADMIN
// =================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');

    // Gestion des utilisateurs
    Route::resource('users', UserController::class)->except(['show']);

    // Gestion des promoteurs
    Route::resource('promoteurs', PromoteurController::class);

    Route::get('/promoteurs/create', [PromoteurController::class, 'create'])->name('promoteurs.create');
    Route::post('/promoteurs', [PromoteurController::class, 'store'])->name('promoteurs.store');
    Route::get('/promoteurs/{id}', [PromoteurController::class, 'show'])->name('promoteurs.show');
    Route::get('/promoteurs/{id}/edit', [PromoteurController::class, 'edit'])->name('promoteurs.edit');
    Route::post('/promoteurs/{promoteur}', [PromoteurController::class, 'update'])->name('promoteurs.update');
    Route::delete('/promoteurs/{promoteur}', [PromoteurController::class, 'destroy'])->name('promoteurs.destroy');

    // Gestion des actions (vue admin)
    Route::get('/actions', [ActionController::class, 'index'])->name('actions.index');

    Route::get('/actions/{action}', [ActionController::class, 'show'])->name('actions.show');


    // Exports
    Route::get('/promoteurs/export/excel', function () {
        return Excel::download(new PromoteursExport, 'promoteurs.xlsx');
    })->name('promoteurs.export.excel');

    Route::get('/promoteurs/export/pdf', [UserController::class, 'exportPromoteursPdf'])
        ->name('promoteurs.export.pdf');

    Route::get('/actions/export/excel', function (\Illuminate\Http\Request $request) {
        return Excel::download(new ActionsExport($request->all()), 'actions.xlsx');
    })->name('actions.export.excel');

    Route::get('/actions/export/pdf', [ActionController::class, 'exportActionsPdf'])
        ->name('actions.export.pdf');
});

// =================
// ROUTES RH & UTILISATEURS CONNECTÉS
// =================
Route::middleware(['auth'])->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [RhController::class, 'index'])->name('dashboard');

    // Gestion du profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // =================
    // PROMOTEURS (Resource complète)
    // =================
    Route::resource('promoteurs', PromoteurController::class);

    Route::get('/promoteurs/create', [PromoteurController::class, 'create'])->name('promoteurs.create');
    Route::post('/promoteurs', [PromoteurController::class, 'store'])->name('promoteurs.store');
    Route::get('/promoteurs/{id}', [PromoteurController::class, 'show'])->name('promoteurs.show');
    Route::get('/promoteurs/{id}/edit', [PromoteurController::class, 'edit'])->name('promoteurs.edit');
    Route::post('/promoteurs/{promoteur}', [PromoteurController::class, 'update'])->name('promoteurs.update');
    Route::delete('/promoteurs/{promoteur}', [PromoteurController::class, 'destroy'])->name('promoteurs.destroy');

    // =================
    // ACTIONS
    // =================
    Route::prefix('promoteurs/{promoteur}')->name('actions.')->group(function () {
        Route::get('/actions/create', [ActionController::class, 'create'])->name('create');
        Route::post('/actions', [ActionController::class, 'store'])->name('store');
    });

    Route::get('/actions/{action}', [ActionController::class, 'show'])->name('actions.show');

    // =================
    // ROUTES RH SPÉCIFIQUES
    // =================
    Route::middleware('role:rh')->prefix('rh')->name('rh.')->group(function () {
        Route::get('/dashboard', [RhController::class, 'dashboard'])->name('dashboard');
        Route::get('/stats', [RhController::class, 'stats'])->name('stats');
        Route::get('/promoteurs/{promoteur}', [RhController::class, 'showPromoteur'])->name('promoteurs.show');
    });
});

// =================
// ROUTES API (optionnel pour AJAX)
// =================
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/promoteurs/{promoteur}/actions', function (\App\Models\Promoteur $promoteur) {
        return response()->json([
            'actions' => $promoteur->actions()->with('createdBy')->latest('date_action')->get()
        ]);
    })->name('promoteurs.actions');

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
