@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-tachometer-alt text-primary"></i> Tableau de Bord</h1>
        <h4 class="text-muted">{{ $wedding->title }}</h4>
    </div>

    <div class="row g-4">
        {{-- Jours Restants --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h6 class="text-uppercase text-muted small">Jours Restants</h6>
                    <h2 class="fw-bold">{{ $daysRemaining > 0 ? $daysRemaining : 'J-J !' }}</h2>
                </div>
            </div>
        </div>

        {{-- Invités Confirmés --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="card-body">
                    <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                    <h6 class="text-uppercase text-muted small">Confirmations</h6>
                    <h2 class="fw-bold">{{ $confirmedGuests }} / {{ $totalGuests }}</h2>
                </div>
            </div>
        </div>

        {{-- Budget Consommé --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="card-body">
                    <i class="fas fa-wallet fa-2x text-danger mb-2"></i>
                    <h6 class="text-uppercase text-muted small">Budget Engagé</h6>
                    <h2 class="fw-bold text-danger">{{ number_format($totalSpent, 0, ',', ' ') }}</h2>
                </div>
            </div>
        </div>

        {{-- Tâches à faire --}}
        <div class="col-md-3">
            <div class="card border-0 shadow-sm text-center p-3">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x text-info mb-2"></i>
                    <h6 class="text-uppercase text-muted small">Tâches Restantes</h6>
                    <h2 class="fw-bold">{{ $pendingTasks }} / {{ $totalTasks }}</h2>
                </div>
            </div>
        </div>
    </div>

    {{-- Analyse Graphique --}}
    <div class="row mt-5">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="mb-3"><i class="fas fa-chart-pie me-2"></i>Utilisation du Budget</h5>
                <div class="progress" style="height: 30px;">
                    <div class="progress-bar bg-danger" role="progressbar" 
                         style="width: {{ $budgetPercentage }}%" 
                         aria-valuenow="{{ $budgetPercentage }}" aria-valuemin="0" aria-valuemax="100">
                         {{ round($budgetPercentage) }}%
                    </div>
                </div>
                <p class="mt-2 text-muted small">Sur un budget total de {{ number_format($wedding->budget_total, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm p-4 text-center">
                <h5>Navigation Rapide</h5>
                <div class="d-flex justify-content-around mt-3">
                    <a href="{{ route('guests.index', $wedding->id) }}" class="btn btn-outline-primary"><i class="fas fa-users"></i> Invités</a>
                    <a href="{{ route('vendors.index', $wedding->id) }}" class="btn btn-outline-warning text-dark"><i class="fas fa-money-bill-wave"></i> Budget</a>
                    <a href="{{ route('tasks.index', $wedding->id) }}" class="btn btn-outline-info"><i class="fas fa-list"></i> Tâches</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection