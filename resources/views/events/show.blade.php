@extends('layouts.main')
@section('title',$event->title)

@section('content')

<style>
:root{
    --amarelo: #ffcc00; 
    --cinza: #cccccc;
}  
.estrelas input[type=radio]{
    display: none;
}      
.estrelas label i.opcao.fa:before{ 
    content: '\f005';  
    color: var(--amarelo);
}
.estrelas input[type=radio]:checked~label i.fa:before{
    color: var(--cinza);
}
</style>


    <div class="col-md-10 offset-md-1 mt-4">
        <div class="row">
            <div class="col-md-6" id="image-container">
                <img
                    src="/img/{{ $event->image ? "events/".$event->image : "curso-default.jpg"}}"
                    alt="{{ $event->title }}"
                    class="img-fluid"
                >
            </div>

            <div class="col-md-6" id="info-container">
                <h1>{{ $event->title }}</h1>

                <p class="event-date text-muted">
                    {{ $event->date_event ? date('d/m/Y', strtotime($event->date_event)) : 'Pendente' }}
                </p>
                <p class="event-city">
                    <ion-icon name="location-outline"></ion-icon>{{ $event->city }}
                </p>
                <p class="event-people">
                    <ion-icon name="people-outline"></ion-icon>
                    {{ count($event->users) }} Participantes
                </p>
                <p class="event-owner">
                    <ion-icon name="star-outline"></ion-icon>
                    {{ $eventowner ? $eventowner['name'] : 'Não definido' }}
                </p>

                @if(!$hasUserJoined)
                    <form action="/events/join/{{ $event->id }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" id="event-submit">Confirmar Presença</button>
                    </form>
                @else
                    <h5 class="text-success">Você já está participante deste evento</h5>
                @endif

                <h3 class="mt-3">Evento conta com:</h3>
                <ul class="list-unstyled">
                    @if($event->items)
                        @foreach($event->items as $item)
                            <li>
                                <ion-icon name="play-outline"></ion-icon> {{$item}}
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="col-md-12 mt-4">
                <h3>Sobre o evento</h3>

                <p class="text-muted">{{ $event->description }}</p>
            </div>

        <form method="POST" action="processa.php">

        <div class="estrelas">

        <!-- Carrega o formulário definindo nenhuma estrela selecionada -->
        <input type="radio" name="estrela" id="vazio" value="" checked>

        <!-- Opção para selecionar 1 estrela -->
        <label for="estrela_um"><i class="opcao fa"></i></label>
        <input type="radio" name="estrela" id="estrela_um" id="vazio" value="1">

        <!-- Opção para selecionar 2 estrela -->
        <label for="estrela_dois"><i class="opcao fa"></i></label>
        <input type="radio" name="estrela" id="estrela_dois" id="vazio" value="2">

        <!-- Opção para selecionar 3 estrela -->
        <label for="estrela_tres"><i class="opcao fa"></i></label>
        <input type="radio" name="estrela" id="estrela_tres" id="vazio" value="3">

        <!-- Opção para selecionar 4 estrela -->
        <label for="estrela_quatro"><i class="opcao fa"></i></label>
        <input type="radio" name="estrela" id="estrela_quatro" id="vazio" value="4">

        <!-- Opção para selecionar 5 estrela -->
        <label for="estrela_cinco"><i class="opcao fa"></i></label>
        <input type="radio" name="estrela" id="estrela_cinco" id="vazio" value="5"><br><br>

        <!-- Campo para enviar a mensagem -->
        <textarea name="mensagem" rows="4" cols="30" placeholder="Digite o seu comentário..."></textarea><br><br>

        <!-- Botão para enviar os dados do formulário -->
        <input type="submit" value="Cadastrar"><br><br>

    </div>

</form>
        </div>
    </div>
@endsection
