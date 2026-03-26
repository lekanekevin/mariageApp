@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('weddings.index') }}">Mes Mariages</a></li>
            <li class="breadcrumb-item active">Checklist : {{ $wedding->title }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 p-4">
                <h4 class="mb-3"><i class="fas fa-tasks text-primary"></i> Nouvelle tâche</h4>
                <form action="{{ route('tasks.store', $wedding->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Ex: Réserver le traiteur" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ajouter à la liste</button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-4">Ma progression</h5>
                    <ul class="list-group list-group-flush">
                        @forelse($wedding->tasks as $task)
                            <li class="list-group-item d-flex justify-content-between align-items-center border-bottom-0 shadow-sm mb-2 rounded">
                                <div class="d-flex align-items-center">
                                    <form action="{{ route('tasks.toggle', $task->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-link p-0 me-3 text-decoration-none">
                                            @if($task->is_completed)
                                                <i class="fas fa-check-circle fa-2x text-success"></i>
                                            @else
                                                <i class="far fa-circle fa-2x text-muted"></i>
                                            @endif
                                        </button>
                                    </form>
                                    <span class="{{ $task->is_completed ? 'text-decoration-line-through text-muted' : 'fw-bold' }}">
                                        {{ $task->title }}
                                    </span>
                                </div>
                                <span class="badge bg-light text-dark">
                                    <i class="fas fa-clock"></i> {{ $task->created_at->diffForHumans() }}
                                </span>
                            </li>
                        @empty
                            <div class="text-center py-4">
                                <i class="fas fa-clipboard-list fa-3x text-light mb-3"></i>
                                <p class="text-muted">Aucune tâche pour le moment. Commencez à planifier !</p>
                            </div>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection