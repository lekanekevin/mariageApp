@extends('layouts.app')

@section('content')
<div class="container mt-5">
    {{-- Alertes de sécurité et succès --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Fil d'Ariane --}}
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('weddings.index') }}">Mes Mariages</a></li>
            <li class="breadcrumb-item active">{{ $wedding->title }}</li>
        </ol>
    </nav>

    <div class="row">
        {{-- Formulaire d'ajout d'invité --}}
        <div class="col-md-4">
            <div class="card p-4 shadow-sm border-0">
                <h4 class="mb-4 text-primary"><i class="fas fa-user-plus"></i> Nouvel Invité</h4>
                
                @php $isFull = $guests->count() >= $wedding->max_guests; @endphp

                <form action="{{ route('guests.store', $wedding->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nom complet</label>
                        <input type="text" name="name" class="form-control" placeholder="Nom de l'invité" required {{ $isFull ? 'disabled' : '' }}>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Statut</label>
                        <select name="status" class="form-select" {{ $isFull ? 'disabled' : '' }}>
                            <option value="en attente">En attente</option>
                            <option value="confirmé">Confirmé</option>
                            <option value="refusé">Refusé</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Table n°</label>
                        <input type="number" name="table_number" class="form-control" placeholder="1, 2..." {{ $isFull ? 'disabled' : '' }}>
                    </div>

                    {{-- Bouton Ajouter --}}
                    <button type="submit" class="btn {{ $isFull ? 'btn-secondary' : 'btn-primary' }} w-100 py-2 mb-2" {{ $isFull ? 'disabled' : '' }}>
                        @if($isFull)
                            <i class="fas fa-lock"></i> Limite atteinte
                        @else
                            <i class="fas fa-save"></i> Ajouter l'invité
                        @endif
                    </button>

                    <hr>

                    {{-- Bouton Télécharger PDF --}}
                    <a href="{{ route('guests.pdf', $wedding->id) }}" class="btn btn-outline-danger w-100 py-2 shadow-sm">
                        <i class="fas fa-file-pdf"></i> Télécharger la liste (PDF)
                    </a>
                </form>
            </div>
        </div>

        {{-- Statistiques et Liste des invités --}}
        <div class="col-md-8">
            {{-- Carte de progression --}}
            <div class="card shadow-sm border-0 mb-4 text-white {{ $isFull ? 'bg-danger' : 'bg-dark' }}">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Occupation Totale</h5>
                        <small>Capacité autorisée : {{ $wedding->max_guests }} personnes</small>
                    </div>
                    <h2 class="mb-0">{{ $guests->count() }} / {{ $wedding->max_guests }}</h2>
                </div>
            </div>

            {{-- Tableau des invités --}}
            <div class="card shadow-sm border-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nom</th>
                                <th>Statut</th>
                                <th>Table</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($guests as $guest)
                            <tr>
                                <td class="fw-bold text-dark">{{ $guest->name }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $guest->status == 'confirmé' ? 'bg-success' : ($guest->status == 'refusé' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                        {{ ucfirst($guest->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted"><i class="fas fa-chair me-1"></i> {{ $guest->table_number ?? 'N/A' }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        {{-- Bouton Modifier --}}
                                        <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-sm btn-outline-secondary" title="Modifier">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>

                                        {{-- Bouton Supprimer --}}
                                        <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" onsubmit="return confirm('Supprimer cet invité ?')" class="d-inline">
                                            @csrf 
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Supprimer">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="fas fa-user-slash fa-2x mb-2 d-block"></i>
                                    Aucun invité pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection