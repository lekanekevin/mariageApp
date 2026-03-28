@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('tasks.index', $wedding->id) }}">Retour aux tâches</a></li>
                    <li class="breadcrumb-item active">Modifier la tâche</li>
                </ol>
            </nav>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0 text-info text-center"><i class="fas fa-edit"></i> Modifier la Tâche</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Titre de la tâche</label>
                            <input type="text" name="title" class="form-control" value="{{ $task->title }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Date limite</label>
                            <input type="date" name="due_date" class="form-control" value="{{ $task->due_date }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Statut</label>
                            <select name="status" class="form-select">
                                <option value="à faire" {{ $task->status == 'à faire' ? 'selected' : '' }}>À faire</option>
                                <option value="en cours" {{ $task->status == 'en cours' ? 'selected' : '' }}>En cours</option>
                                <option value="terminé" {{ $task->status == 'terminé' ? 'selected' : '' }}>Terminé</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-info text-white shadow-sm">Enregistrer les modifications</button>
                            <a href="{{ route('tasks.index', $wedding->id) }}" class="btn btn-light border">Annuler</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection