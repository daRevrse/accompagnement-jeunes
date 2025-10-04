@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-speedometer2"></i> Tableau de bord administrateur</h1>
        <span class="badge bg-primary fs-6">{{ now()->locale('fr_FR')->isoFormat('dddd D MMMM YYYY') }}</span>
    </div>

    {{-- Cartes de statistiques --}}
    <div class="row mb-4 g-4">
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Promoteurs</h6>
                            <h2 class="mb-0 fw-bold">{{ $nbPromoteurs }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <i class="bi bi-arrow-up-circle me-2"></i>
                        <small>Total enregistrés</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="background: linear-gradient(135deg, #56ab2f 0%, #a8e063 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Actions</h6>
                            <h2 class="mb-0 fw-bold">{{ $nbActions }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-journal-text"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <i class="bi bi-graph-up me-2"></i>
                        <small>Suivis effectués</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">Entreprises actives</h6>
                            <h2 class="mb-0 fw-bold">{{ $actives }}</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-building-check"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <i class="bi bi-check-circle me-2"></i>
                        <small>En activité</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 15px;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 opacity-75">CA Total</h6>
                            <h2 class="mb-0 fw-bold">{{ number_format($totalChiffreAffaires / 1000000, 1) }}M</h2>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-currency-dollar"></i>
                        </div>
                    </div>
                    <div class="mt-3 d-flex align-items-center">
                        <i class="bi bi-cash-stack me-2"></i>
                        <small>Chiffre d'affaires (FCFA)</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="padding: 30px;">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-bar-chart-line"></i> Évolution des actions (12 derniers mois)
                    </h5>
                    <canvas id="actionsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body" style="padding: 30px;">
                    <h5 class="card-title mb-4">
                        <i class="bi bi-pie-chart"></i> Répartition des entreprises
                    </h5>
                    <canvas id="repartitionChart" height="250"></canvas>

                    <div class="mt-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><i class="bi bi-circle-fill text-success"></i> Actives</span>
                            <strong>{{ $actives }}</strong>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-circle-fill text-danger"></i> Inactives</span>
                            <strong>{{ $inactives }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Accès rapides --}}
    <div class="row g-4 mt-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-people-fill" style="font-size: 3rem; color: #667eea;"></i>
                    </div>
                    <h5 class="card-title">Gestion des promoteurs</h5>
                    <p class="text-muted">Ajouter, modifier ou consulter les promoteurs</p>
                    <a href="{{ route('admin.promoteurs.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-right-circle"></i> Accéder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-journal-text" style="font-size: 3rem; color: #56ab2f;"></i>
                    </div>
                    <h5 class="card-title">Actions et suivis</h5>
                    <p class="text-muted">Consulter toutes les actions enregistrées</p>
                    <a href="{{ route('admin.actions.index') }}" class="btn btn-success">
                        <i class="bi bi-arrow-right-circle"></i> Accéder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="bi bi-person-gear" style="font-size: 3rem; color: #4facfe;"></i>
                    </div>
                    <h5 class="card-title">Gestion des utilisateurs</h5>
                    <p class="text-muted">Gérer les accès et les permissions</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-info">
                        <i class="bi bi-arrow-right-circle"></i> Accéder
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts pour les graphiques --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Graphique des actions par mois
        const ctxActions = document.getElementById('actionsChart');
        new Chart(ctxActions, {
            type: 'line',
            data: {
                labels: @json($moisLabels),
                datasets: [{
                    label: 'Nombre d\'actions',
                    data: @json($moisData),
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true,
                    borderWidth: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });

        // Graphique circulaire
        const ctxRepartition = document.getElementById('repartitionChart');
        new Chart(ctxRepartition, {
            type: 'doughnut',
            data: {
                labels: ['Actives', 'Inactives'],
                datasets: [{
                    data: [{
                        {
                            $actives
                        }
                    }, {
                        {
                            $inactives
                        }
                    }],
                    backgroundColor: [
                        'rgba(86, 171, 47, 0.8)',
                        'rgba(235, 51, 73, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>
@endsection