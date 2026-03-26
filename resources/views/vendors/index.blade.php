@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Fil d'Ariane --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('weddings.index') }}">Mes Mariages</a></li>
            <li class="breadcrumb-item active">Budget & Prestataires : {{ $wedding->title }}</li>
        </ol>
    </nav>

    {{-- Résumé du Budget --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body">
                    <h6>Budget Initial</h6>
                    <h3>{{ number_format($wedding->budget_total, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-danger text-white shadow-sm border-0">
                <div class="card-body">
                    <h6>Dépenses Totales (Engagées)</h6>
                    <h3>{{ number_format($totalSpent, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card {{ $remainingBudget < 0 ? 'bg-warning' : 'bg-success' }} text-white shadow-sm border-0">
                <div class="card-body">
                    <h6>Solde Restant</h6>
                    <h3>{{ number_format($remainingBudget, 0, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Formulaire d'ajout --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 text-primary"><i class="fas fa-truck text-secondary"></i> Nouveau Prestataire</h4>
                <form action="{{ route('vendors.store', $wedding->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom / Entreprise</label>
                        <input type="text" name="name" class="form-control" placeholder="Ex: Traiteur Saveurs du Pays" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie</label>
                        <select name="category" class="form-select" required>
                            <option value="Traiteur">Traiteur</option>
                            <option value="Boisson">Boisson</option>
                            <option value="Musique/DJ">Musique/DJ</option>
                            <option value="Photographe">Photographe</option>
                            <option value="Décoration">Décoration</option>
                            <option value="Location Salle">Location Salle</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Prix total convenu (FCFA)</label>
                        <input type="number" name="price" class="form-control" placeholder="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Acompte versé (FCFA)</label>
                        <input type="number" name="paid_amount" class="form-control" value="0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 shadow-sm">
                        <i class="fas fa-plus"></i> Ajouter au budget
                    </button>
                </form>
            </div>
        </div>

        {{-- Liste des Prestataires --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Prestataire</th>
                                <th>Prix</th>
                                <th>Payé</th>
                                <th>Reste</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vendors as $vendor)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $vendor->name }}</div>
                                    <small class="text-muted">{{ $vendor->category }}</small>
                                </td>
                                <td class="fw-bold">{{ number_format($vendor->price, 0, ',', ' ') }}</td>
                                <td class="text-success">{{ number_format($vendor->paid_amount, 0, ',', ' ') }}</td>
                                <td class="text-danger fw-bold">
                                    {{ number_format($vendor->price - $vendor->paid_amount, 0, ',', ' ') }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('vendors.edit', $vendor->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        <form action="{{ route('vendors.destroy', $vendor->id) }}" method="POST" onsubmit="return confirm('Supprimer ce prestataire ?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger ms-1">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">Aucun prestataire enregistré.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection