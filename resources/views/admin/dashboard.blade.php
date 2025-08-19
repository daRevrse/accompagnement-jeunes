@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
<div class="container">
    <h1 class="mb-4">👑 Tableau de bord administrateur</h1>

    {{-- Cartes de statistiques --}}
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <div class="display-4">{{ $nbPromoteurs }}</div>
                    <h6 class="card-title">👥 Promoteurs</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <div class="display-4">{{ $nbActions }}</div>
                    <h6 class="card-title">📄 Actions</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <div class="display-4">{{ $actives }}</div>
                    <h6 class="card-title">✅ Actives</h6>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <div class="h5">{{ number_format($totalChiffreAffaires, 0, ',', ' ') }}</div>
                    <h6 class="card-title">💰 CA Total (FCFA)</h6>
                </div>
            </div>
        </div>
    </div>

    {{-- Graphiques --}}
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📈 Évolution des actions (12 derniers mois)</h5>
                </div>
                <div class="card-body">
                    <canvas id="actionsChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">🏢 Répartition des entreprises</h5>
                </div>
                <div class="card-body">
                    <canvas id="repartitionChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts optimisés --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Configuration des graphiques
        const chartOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        };

        // Graphique linéaire des actions
        const ctx1 = document.getElementById('actionsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: @json($moisLabels),
                datasets: [{
                    label: 'Nombre d\'actions',
                    data: @json($moisData),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.1)',
                    tension: 0.3,
                    fill: true
                }]
            },
            options: {
                ...chartOptions,
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

        // Graphique en camembert
        const ctx2 = document.getElementById('repartitionChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Actives', 'Inactives'],
                datasets: [{
                    data: [@json($actives), @json($inactives)],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: chartOptions
        });
    });
</script>
@endsection