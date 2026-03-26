@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('guests.index', $wedding->id) }}">Retour aux invités</a></li>
                    <li class="breadcrumb-item active">Modifier {{ $guest->name }}</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 text-center">
                    <h4 class="mb-0 text-primary"><i class="fas fa-user-edit"></i> Modifier l'invité</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('guests.update', $guest->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nom complet</label>
                            <input type="text" name="name" class="form-control" value="{{ $guest->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Statut</label>
                            <select name="status" class="form-select">
                                <option value="en attente" {{ $guest->status == 'en attente' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmé" {{ $guest->status == 'confirmé' ? 'selected' : '' }}>Confirmé</option>
                                <option value="refusé" {{ $guest->status == 'refusé' ? 'selected' : '' }}>Refusé</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Table n°</label>
                            <input type="number" name="table_number" class="form-control" value="{{ $guest->table_number }}">
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100 py-2">Mettre à jour</button>
                            <a href="{{ route('guests.index', $wedding->id) }}" class="btn btn-light border w-100 py-2">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection