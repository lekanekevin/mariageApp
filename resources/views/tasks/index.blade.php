@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-list-check text-info"></i> Liste des Tâches</h1>
        <h5 class="text-muted">{{ $wedding->title }}</h5>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-4 text-info">Nouvelle Tâche</h4>
                <form action="{{ route('tasks.store', $wedding->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre</label>
                        <input type="text" name="title" class="form-control" placeholder="Ex: Réserver le DJ" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Date limite</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-info text-white w-100 shadow-sm">Ajouter</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Statut</th>
                            <th>Tâche</th>
                            <th>Échéance</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr>
                            <td style="width: 150px;">
                                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="form-select form-select-sm 
                                        {{ $task->status == 'terminé' ? 'bg-success text-white' : '' }}">
                                        <option value="à faire" {{ $task->status == 'à faire' ? 'selected' : '' }}>À faire</option>
                                        <option value="en cours" {{ $task->status == 'en cours' ? 'selected' : '' }}>En cours</option>
                                        <option value="terminé" {{ $task->status == 'terminé' ? 'selected' : '' }}>Terminé</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <span class="{{ $task->status == 'terminé' ? 'text-decoration-line-through text-muted' : 'fw-bold' }}">
                                    {{ $task->title }}
                                </span>
                            </td>
                            <td>
                                @if($task->due_date)
                                    <small class="badge bg-light text-dark border">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('d/m/Y') }}
                                    </small>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group">
                                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>

                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Supprimer cette tâche ?')">
                                        @csrf 
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger ms-1">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">Aucune tâche pour le moment.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection