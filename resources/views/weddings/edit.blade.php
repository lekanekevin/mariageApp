@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4 shadow-sm border-0">
                <h2 class="text-center mb-4 text-primary"><i class="fas fa-edit"></i> Modifier le Mariage</h2>
                
                <form action="{{ route('weddings.update', $wedding->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom du mariage</label>
                        <input type="text" name="title" class="form-control" value="{{ $wedding->title }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Date du mariage</label>
                        <input type="datetime-local" name="date" class="form-control" value="{{ $wedding->date }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Budget (FCFA)</label>
                        <input type="number" name="budget_total" class="form-control" value="{{ $wedding->budget_total }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre d'invités max</label>
                        <input type="number" name="max_guests" class="form-control" value="{{ $wedding->max_guests }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Lieu</label>
                        <input type="text" name="location" class="form-control" value="{{ $wedding->location }}">
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary w-100 py-2">Sauvegarder les modifications</button>
                        <a href="{{ route('weddings.index') }}" class="btn btn-light border w-100 py-2">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection