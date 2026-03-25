@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="fas fa-calendar-alt"></i> Mes Projets</h1>
        <a href="{{ route('weddings.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Nouveau
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Mariage</th>
                        <th>Lieu</th>
                        <th>Budget</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($weddings as $wedding)
                    <tr>
                        <td class="fw-bold"><i class="fas fa-glass-cheers me-2"></i>{{ $wedding->title }}</td>
                        <td><i class="fas fa-map-pin me-1 text-muted"></i> {{ $wedding->location ?? 'Non défini' }}</td>
                        <td><span class="badge bg-info text-dark">{{ number_format($wedding->budget_total, 0, ',', ' ') }} FCFA</span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection