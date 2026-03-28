@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt text-primary"></i> Mon Projet de mariage </h1>
        <a href="{{ route('weddings.create') }}" class="btn btn-success shadow-sm">
            <i class="fas fa-plus"></i> Nouveau Mariage
        </a>
        {{-- L'erreur a été supprimée d'ici (le bouton ne peut pas être ici car $wedding n'est pas défini) --}}
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mariage</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        <th>Budget</th>
                        <th>Capacité</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weddings as $wedding)
                    <tr>
                        <td class="fw-bold text-dark">
                            <i class="fas fa-glass-cheers me-2 text-primary"></i>{{ $wedding->title }}
                        </td>
                        <td class="fw-bold text-dark">
                            <i class="fas fa-calendar me-2 text-primary"></i>{{ $wedding->date }}
                        </td>
                        <td>
                            <i class="fas fa-map-pin me-1 text-muted"></i> 
                            {{ $wedding->location ?? 'Non défini' }}
                        </td>
                        <td>
                            <span class="badge bg-info text-dark px-3">
                                {{ number_format($wedding->budget_total, 0, ',', ' ') }} FCFA
                            </span>
                        </td>
                        <td>
                            <span class="text-secondary">
                                <i class="fas fa-users me-1"></i> {{ $wedding->max_guests }} places
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('wedding.dashboard', $wedding->id) }}" class="btn btn-sm btn-dark" title="Dashboard">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                {{-- Bouton Invités --}}
                                <a href="{{ route('guests.index', $wedding->id) }}" class="btn btn-sm btn-outline-primary" title="Invités">
                                    <i class="fas fa-users"></i>
                                </a>
                                
                                {{-- Bouton Tâches --}}
                                <a href="{{ route('tasks.index', $wedding->id) }}" class="btn btn-sm btn-outline-info" title="Tâches">
                                    <i class="fas fa-list-check"></i>
                                </a>

                                {{-- LE BOUTON BUDGET (Placé ici, il fonctionne car il connaît $wedding->id) --}}
                                <a href="{{ route('vendors.index', $wedding->id) }}" class="btn btn-sm btn-outline-warning" title="Budget & Prestataires">
                                    <i class="fas fa-money-bill-wave text-dark"></i>
                                </a>

                                {{-- Bouton Modifier --}}
                                <a href="{{ route('weddings.edit', $wedding->id) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- Bouton Supprimer --}}
                                <form action="{{ route('weddings.destroy', $wedding->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Attention ! Supprimer ce mariage effacera TOUTES les données liées (invités, tâches, etc.). Continuer ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection