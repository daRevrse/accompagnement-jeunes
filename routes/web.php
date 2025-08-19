<?php

use App\Exports\ActionsExport;
use App\Exports\PromoteursExport;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromoteurController;
use App\Http\Controllers\ActionController;
use App\Http\Controllers\RhController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Request;
use Maatwebsite\Excel\Facades\Excel;

// Page d'accueil
Route::get('/', function () {
    return view('welcome');
});

// Authentification
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Enregistrement du formulaire
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);



Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [AdminDashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    Route::resource('actions', ActionController::class)->only(['index', 'create', 'store', 'show', 'exportActionsPdf']);

    Route::get('admin/promoteurs/export/excel', fn() => Excel::download(new PromoteursExport, 'promoteurs.xlsx'))
        ->name('promoteurs.export.excel');

    Route::get('admin/promoteurs/export/pdf', [UserController::class, 'exportPromoteursPdf'])
        ->name('promoteurs.export.pdf');

    Route::get('/admin/actions/export/excel', function (\Illuminate\Http\Request $request) {
        return Excel::download(new ActionsExport($request->all()), 'actions.xlsx');
    })->name('actions.export.excel');

    Route::get('/admin/actions/export/pdf', [ActionController::class, 'exportActionsPdf'])
        ->name('actions.export.pdf');
});

// Groupe des routes protégées par authentification
Route::middleware(['auth'])->group(function () {


    // Formulaire d’inscription



    // Dashboard
    Route::get('/dashboard', [RhController::class, 'index'])->name('dashboard');

    Route::resource('promoteurs', PromoteurController::class);

    // Promoteurs
    Route::get('/promoteurs', [PromoteurController::class, 'index'])->name('promoteurs.index');
    Route::get('/promoteurs/create', [PromoteurController::class, 'create'])->name('promoteurs.create');
    Route::post('/promoteurs', [PromoteurController::class, 'store'])->name('promoteurs.store');
    Route::get('/promoteurs/{id}', [PromoteurController::class, 'show'])->name('promoteurs.show');

    // Actions liées à un promoteur
    Route::get('/promoteurs/{id}/actions/create', [ActionController::class, 'create'])->name('actions.create');
    Route::post('/promoteurs/{id}/actions', [ActionController::class, 'store'])->name('actions.store');

    Route::get('/promoteurs/{promoteur}/edit', [App\Http\Controllers\PromoteurController::class, 'edit'])->name('promoteurs.edit');
    Route::post('/promoteurs/{promoteur}', [App\Http\Controllers\PromoteurController::class, 'update'])->name('promoteurs.update');

    Route::delete('/promoteurs/{id}', [PromoteurController::class, 'destroy'])->name('promoteurs.destroy');

    Route::get('/actions/{id}', [ActionController::class, 'show'])->name('actions.show');
    // Route::get('/promoteur-actions', PromoteurActions::class);

    // Route::get('/promoteur-actions', \App\Livewire\PromoteurActions::class);
    // OU sans le \ en enlevant $namespace dans RouteServiceProvider


});
