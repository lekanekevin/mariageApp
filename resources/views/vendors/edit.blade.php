@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('vendors.index', $wedding->id) }}">Retour au budget</a></li>
                    <li class="breadcrumb-item active">Modifier {{ $vendor->name }}</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-primary text-center"><i class="fas fa-user-edit"></i> Modifier le Prestataire</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('vendors.update', $vendor->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom / Entreprise</label>
                            <input type="text" name="name" class="form-control" value="{{ $vendor->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Catégorie</label>
                            <select name="category" class="form-select" required>
                                @foreach(['Traiteur', 'Boisson', 'Musique/DJ', 'Photographe', 'Décoration', 'Location Salle', 'Autre'] as $cat)
                                    <option value="{{ $cat }}" {{ $vendor->category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Prix total convenu (FCFA)</label>
                            <input type="number" name="price" class="form-control" value="{{ $vendor->price }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Acompte versé (FCFA)</label>
                            <input type="number" name="paid_amount" class="form-control" value="{{ $vendor->paid_amount }}" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 py-2">Enregistrer les modifications</button>
                            <a href="{{ route('vendors.index', $wedding->id) }}" class="btn btn-light border w-100 py-2">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection