@extends('layouts.main')
@section('title','Dashboard')

@section('content')
    <div class="col-md-10 offset-md-1 py-4">
        <h2>Meus eventos</h2>
    </div>

    <div class="col-md-10 offset-md-1">
        @if(count($events) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Participante</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($events as $event)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <a href="/events/{{ $event->id }}">{{ $event->title }}</a>
                        </td>
                        <td>{{ count($event->users) }}</td>
                        <td>
                            <div class="d-md-flex justify-md-between flex-row">

                                <a
                                    class="btn btn-sm btn-outline-secondary me-2 d-inline"
                                    href="/events/edit/{{ $event->id }}"
                                >
                                    <ion-icon name="create-outline"></ion-icon>
                                    Editar
                                </a>

                                <form class="d-inline" action="/events/{{ $event->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="btn btn-sm btn-outline-danger"
                                        type="submit">
                                        <ion-icon name="trash-outline"></ion-icon>
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda não tem eventos <a href="/events/create">Criar eventos</a></p>
        @endif
    </div>

    <div class="col-md-10 offset-md-1 py-4">
        <h2>Eventos que estou participando</h2>
    </div>

    <div class="col-md-10 offset-md-1">
        @if(count($eventsasparticipant) > 0)
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Participante</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach($eventsasparticipant as $event)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            <a href="/events/{{ $event->id }}">{{ $event->title }}</a>
                        </td>
                        <td>{{ count($event->users) }}</td>
                        <td>
                            <form action="/events/leave/{{ $event->id }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-sm btn-outline-danger me-2 d-inline"
                                >
                                    <ion-icon name="trash-outline"></ion-icon>
                                    Sair do evento
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Você ainda não está participante de nenhum evento</p>
        @endif
    </div>
@endsection
