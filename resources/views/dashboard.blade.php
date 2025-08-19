@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">📊 Tableau de bord</h1>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">👥 Nombre de promoteurs</h5>
                    <p class="card-text display-6 text-success">{{ $nbPromoteurs }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📝 Nombre total d'actions</h5>
                    <p class="card-text display-6 text-primary">{{ $nbActions }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection