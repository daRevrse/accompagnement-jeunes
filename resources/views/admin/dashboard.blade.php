@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container">
    <h1 class="mb-4">👑 Tableau de bord administrateur</h1>

    {{-- Résumé --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5>👥 Promoteurs</h5>
                    <p class="display-6">{{ $nbPromoteurs }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5>📄 Actions</h5>
                    <p class="display-6">{{ $nbActions }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5>💰 Chiffre d'affaires</h5>
                    <p class="display-6">{{ number_format($totalChiffreAffaires, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5>📆 Actions par mois</h5>
                    <canvas id="actionsChart" height="100"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5>🏢 Entreprises actives</h5>
                    <canvas id="repartitionChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<canvas id="actionsChart" height="100"></canvas>
<canvas id="repartitionChart" height="200"></canvas>

<script>
    // Graphique des actions par mois (ligne)
    const ctx1 = document.getElementById('actionsChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: @json($moisLabels),
            datasets: [{
                label: 'Actions',
                data: @json($moisData),
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Camembert des entreprises actives/inactives
    const ctx2 = document.getElementById('repartitionChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Actives', 'Inactives'],
            datasets: [{
                data: @json([$actives, $inactives]),
                backgroundColor: ['#28a745', '#dc3545'],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endsection