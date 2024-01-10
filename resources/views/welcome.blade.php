@extends('layouts.main')

@section('title','Início')

@section('content')

    <div class="container">
        <div class="col-md-12 my-5" id="search-container">
            <h2>Busque um Evento</h2>

            <form action="/" method="GET">
                <input class="form-control" type="text" id="search" name="search" placeholder="procurar">
            </form>
        </div>

        <div class="col-md-12 my-5" id="events-container">
            @if($search)
                <h2>Buscando por: {{ $search }}</h2>
                <p>{{ count($events) }} resultado encontrado</p>
            @else
                <h2>Próximos eventos</h2>
            @endif

            <p>Veja os eventos dos próximos dias</p>

            <div class="row" id="cards-container">
                @foreach($events as $event)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3">
                        <div class="card h-100">

                            <img
                                class="img-fluid"
                                src="/img/{{ $event->image ? "events/{$event->image}" : "curso-default.jpg" }}"
                                alt="{{ $event->title }}"
                            >

                            <div class="card-body">
                                <h6 class="card-title font-weight-bold">{{ $event->title }}</h6>
                                <p class="card-date text-muted mb-0">{{ $event->date_event ? date('d/m/Y', strtotime($event->date_event)) : 'Pendente' }}</p>
                                <p>
                                    <small class="card-participants text-muted">{{ count($event->users) }} participantes</small>
                                </p>
                                <a
                                    class="btn btn-primary btn-sm float-end"
                                    href="/events/{{$event->id}}">Saber mais</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if(count($events) == 0 && $search)
                    <p>Não foi possivel encontrar nenhum evento com {{$search}}</p>
                @elseif(count($events) == 0)
                    <p>Não há eventos disponiveis</p>
                @endif
            </div>
        </div>
    </div>
@endsection
