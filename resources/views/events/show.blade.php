@extends('layouts.app')

@section('title', $event->title)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <span class="badge text-bg-secondary mb-3">
                    {{ $event->category->name }}
                </span>
                <h1 class="h2">
                    {{ $event->title }}
                </h1>
                <p class="lead">
                    {{ $event->description }}
                </p>
                <hr>
                <dl class="row">
                    <dt class="col-sm-4">Local</dt>
                    <dd class="col-sm-8">{{ $event->location }}</dd>

                    <dt class="col-sm-4">Início</dt>
                    <dd class="col-sm-8">{{ $event->start_at->format('d/m/Y H:i') }}</dd>

                    <dt class="col-sm-4">Término</dt>
                    <dd class="col-sm-8">{{ $event->end_at->format('d/m/Y H:i') }}</dd>

                    <dt class="col-sm-4">Vagas</dt>
                    <dd class="col-sm-8">{{ $confirmedCount }} / {{ $event->capacity }}</dd>
                </dl>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5">Inscrição</h2>

                @php
                    $available = $event->capacity - $confirmedCount;
                    $canRegister = $event->status === 'scheduled' && !$event->hasStarted() && $available > 0;
                @endphp

                @if($event->isCanceled())
                    <div class="alert alert-danger">
                        Este evento foi cancelado.
                    </div>
                @elseif($event->hasFinished())
                    <div class="alert alert-secondary">
                        Este evento já foi encerrado.
                    </div>
                @elseif($event->hasStarted())
                    <div class="alert alert-warning">
                        Este evento já começou.
                    </div>
                @elseif($registration?->isConfirmed())
                    <div class="alert alert-success">
                        Você está inscrito neste evento.
                    </div>
                    <form method="POST" action="{{ route('registrations.destroy', $registration) }}">
                        @csrf
                        @method('DELETE')
                        <button 
                            class="btn btn-outline-danger w-100"
                            onclick="return confirm('Cancelar sua inscrição?')"
                        >
                            Cancelar inscrição
                        </button>
                    </form>
                @elseif(!$canRegister)
                    <div class="alert alert-warning">
                        Não existem vagas disponíveis.
                    </div>
                @else
                    <p>
                        Vagas disponíveis: <strong>{{ $available }}</strong>
                    </p>
                    <form method="POST" action="{{ route('registrations.store', $event) }}">
                        @csrf
                        <button class="btn btn-primary w-100">
                            {{ $registration?->isCanceled() ? 'Realizar nova inscrição' : 'Inscrever-se' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection