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

        <label for="">Nivel de Seguridad</label><br>
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

        function getColorPorNivel(nivel) {
            switch (nivel) {
                case 'Baja': return "#44FF44";  // Verde
                case 'Media': return "#FFB800"; // Amarillo
                case 'Alta': return "#FF3333";  // Rojo
                default: return "#999999";     // Gris neutro
            }
        }

        function initMapZonaEditar() {
            const lat = parseFloat(document.getElementById('latitud').value);
            const lng = parseFloat(document.getElementById('longitud').value);
            const radio = parseFloat(document.getElementById('radio').value);
            const tipo = document.getElementById('tipo').value;

            const centro = new google.maps.LatLng(lat, lng);

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

            circulo = new google.maps.Circle({
                strokeColor: "#000000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: getColorPorNivel(tipo),
                fillOpacity: 0.4,
                map: mapa,
                center: centro,
                radius: radio
            });

            // Actualiza coordenadas y centro del círculo al mover marcador
            marcador.addListener('dragend', function () {
                const nuevaPos = this.getPosition();
                document.getElementById('latitud').value = nuevaPos.lat();
                document.getElementById('longitud').value = nuevaPos.lng();
                circulo.setCenter(nuevaPos);
            });

            // Actualiza radio del círculo en tiempo real
            document.getElementById('radio').addEventListener('input', function () {
                circulo.setRadius(parseFloat(this.value));
            });

            // Actualiza color del círculo según tipo
            document.getElementById('tipo').addEventListener('change', function () {
                const nuevoColor = getColorPorNivel(this.value);
                circulo.setOptions({ fillColor: nuevoColor });
            });
        }
    </script>

</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMapZonaEditar"></script>

@endsection
