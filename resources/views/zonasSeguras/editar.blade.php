@extends('layouts.app')
@section('contenido')

<div class="container">
    <h1 class="text-center">Editar Zona Segura</h1>

    <form action="{{ route('zonasSeguras.update', $zona->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="">Nombre</label><br>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $zona->nombre }}"><br>

        <label for="">Radio</label><br>
        <input type="number" name="radio" id="radio" class="form-control" value="{{ $zona->radio }}"><br>

        <label for="">Tipo de Seguridad</label><br>
        <select name="tipo" id="tipo" class="form-control">
            <option value="Baja" {{ $zona->tipo == 'Baja' ? 'selected' : '' }}>Baja</option>
            <option value="Media" {{ $zona->tipo == 'Media' ? 'selected' : '' }}>Media</option>
            <option value="Alta" {{ $zona->tipo == 'Alta' ? 'selected' : '' }}>Alta</option>
        </select><br>

        <div class="row">
            <div class="col-md-6">
                <label>Latitud</label>
                <input type="text" name="latitud" id="latitud" class="form-control" value="{{ $zona->latitud }}">
            </div>
            <div class="col-md-6">
                <label>Longitud</label>
                <input type="text" name="longitud" id="longitud" class="form-control" value="{{ $zona->longitud }}">
            </div>
        </div><br>

        <div id="mapa_editar_zona" style="border:2px solid black; height:300px; width:100%;"></div><br>

        <button class="btn btn-warning">Actualizar</button>
        <a href="{{ route('zonasSeguras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    <script>
        let mapa, marcador, circulo;

        function initMapZonaEditar() {
            const centro = new google.maps.LatLng({{ $zona->latitud }}, {{ $zona->longitud }});

            mapa = new google.maps.Map(document.getElementById('mapa_editar_zona'), {
                center: centro,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            marcador = new google.maps.Marker({
                position: centro,
                map: mapa,
                title: "Mover ubicación si es necesario",
                draggable: true
            });

            // Dibuja el círculo inicial
            circulo = new google.maps.Circle({
                strokeColor: "black",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "green",
                fillOpacity: 0.4,
                map: mapa,
                center: centro,
                radius: parseFloat(document.getElementById('radio').value)
            });

            // Actualiza coordenadas y círculo al mover marcador
            marcador.addListener('dragend', function () {
                const lat = this.getPosition().lat();
                const lng = this.getPosition().lng();
                document.getElementById('latitud').value = lat;
                document.getElementById('longitud').value = lng;
                circulo.setCenter(this.getPosition());
            });

            // Actualiza radio del círculo en tiempo real
            document.getElementById('radio').addEventListener('input', function () {
                const nuevoRadio = parseFloat(this.value);
                circulo.setRadius(nuevoRadio);
            });
        }
    </script>

</div>

<!-- API de Google Maps -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMapZonaEditar"></script>

@endsection
