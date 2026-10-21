@extends('layouts.app')

@section('title', 'Eventos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            Eventos disponíveis
        </h1>
        <p class="text-muted mb-0">
            Encontre um evento e faça sua inscrição.
        </p>
    </div>
</div>

<form method="GET" action="{{ route('events.index') }}" class="card card-body mb-4">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">
                Pesquisar
            </label>
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Nome ou descrição" 
                value="{{ request('search') }}"
            >
        </div>
        <div class="col-md-4">
            <label class="form-label">
                Categoria
            </label>
            <select name="category_id" class="form-select">
                <option value="">
                    Todas
                </option>
                @foreach($categories as $category)
                    <option 
                        value="{{ $category->id }}"
                        @selected(request('category_id') == $category->id)
                    >
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">
                Filtrar
            </button>
        </div>
    </div>
</form>

<div class="row g-4">
    @forelse($events as $event)
        @php
            $available = $event->capacity - $event->confirmed_registrations_count;
        @endphp
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <span class="badge text-bg-secondary align-self-start mb-2">
                        {{ $event->category->name }}
                    </span>
                    <h2 class="h5">
                        {{ $event->title }}
                    </h2>
                    <p class="text-muted">
                        {{ Str::limit($event->description, 120) }}
                    </p>
                    <div class="small mb-3">
                        <div>
                            📍 {{ $event->location }}
                        </div>
                        <div>
                            📅 {{ $event->start_at->format('d/m/Y H:i') }}
                        </div>
                        <div>
                            👥 {{ $available }} vaga(s)
                        </div>
                    </div>
                    <a 
                        href="{{ route('events.show', $event) }}" 
                        class="btn btn-primary mt-auto"
                    >
                        Ver detalhes
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info">
                Nenhum evento encontrado.
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $events->links() }}
</div>
@endsection