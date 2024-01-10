@extends('layouts.main')
@section('title','Criar evento')

@section('content')

    <div class="col-md-6 offset-md-3 mt-5" id="event-create-container">
        <h2>Crie seu evento</h2>

        <form action="/events" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title">Evento</label>
                <input
                    type="text"
                    class="form-control"
                    id="title"
                    name="title"
                    placeholder="Nome do evento"
                >
            </div>

            <div class="mb-3">
                <label for="description">Descrição</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                ></textarea>
            </div>

            <div class="mb-3">
                <label for="city">Cidade</label>
                <input
                    type="text"
                    class="form-control"
                    id="city"
                    name="city"
                    placeholder="Nome da cidade"
                >
            </div>

            <div class="mb-3">
                <label for="date_event">Data do evento</label>
                <input
                    type="date"
                    class="form-control"
                    id="date_event"
                    name="date_event"
                >
            </div>

            <div class="mb-3">
                <label for="private">O evento é privado?</label>
                <select name="private" id="private" class="form-control">
                    <option value=""></option>
                    <option value="1">Sim</option>
                    <option value="0">Não</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="image">Imagem do evento</label>
                <input
                    type="file"
                    class="form-control"
                    id="image"
                    name="image"
                >
            </div>

            <div class="mb-3">
                <label for="image">Adicione itens de infraestrutura</label>
                <div class="form-group">
                    <input type="checkbox" name="items[]" id="cadeiras" value="value"> <label
                        for="cadeiras">Cadeiras</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" id="palco" value="palco"> <label for="palco">Palco</label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" id="cerveja" value="cerveja">
                    <label for="cerveja">Cerveja grátis </label>
                </div>
                <div class="form-group">
                    <input type="checkbox" name="items[]" id="food" value="food">
                    <label for="food">Open food </label>
                </div>
            </div>

            <div class="mb-3">
                <button class="btn btn-success" type="submit">Enviar</button>
            </div>
        </form>
    </div>
@endsection
