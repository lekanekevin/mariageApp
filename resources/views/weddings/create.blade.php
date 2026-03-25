@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <h2 class="text-center mb-4"><i class="fas fa-heart text-danger"></i> Nouveau Mariage</h2>
                
                <form action="{{ route('weddings.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nom du mariage</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-ring text-gold"></i></span>
                            <input type="text" name="title" class="form-control" placeholder="Ex: Julie & Marc 2026" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Budget prévu (FCFA)</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-money-bill-wave text-success"></i></span>
                            <input type="number" name="budget_total" class="form-control" placeholder="0" step="1">
                            <span class="input-group-text">FCFA</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Lieu de la réception</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-map-marker-alt text-primary"></i></span>
                            <input type="text" name="location" class="form-control" placeholder="Ville, Salle...">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-3">
                        <i class="fas fa-plus-circle"></i> Créer mon projet
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection