@extends('layouts.app')
@section('contenido')

<div class="container">
    <h1 class="text-center">Agregar Zona Segura</h1>

    <form action="{{ route('zonasSeguras.store') }}" method="POST" id="frm_nueva_zona_segura">
        @csrf

        <label for="">Nombre</label><br>
        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre descriptivo"><br>

        <label for="">Radio</label><br>
        <input type="number" name="radio" id="radio" class="form-control" placeholder="Ej. 50"><br>

        <label for="">Tipo de Seguridad</label><br>
        <select name="tipo" id="tipo" class="form-control">
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
        </select><br>

        <div class="row">
            <div class="col-md-6">
                <label>Latitud</label>
                <input type="text" name="latitud" id="latitud" class="form-control" readonly>
            </div>
            <div class="col-md-6">
                <label>Longitud</label>
                <input type="text" name="longitud" id="longitud" class="form-control" readonly>
            </div>
        </div><br>

        <div id="zona_segura" style="border:2px solid black; height:300px; width:100%;"></div><br>

        <button class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGraficoCirculo" onclick="graficarZonaSegura();">Graficar</button>
        <a href="{{ route('zonasSeguras.index') }}" class="btn btn-danger">Cancelar</a>
    </form>

    <!-- Modal para graficar -->
    <div class="modal fade" id="modalGraficoCirculo" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Área de Protección</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="mapa-circulo-zona" style="border:2px solid blue; height:300px;"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let mapa;
        function initMapZona() {
            const centro = new google.maps.LatLng(-0.9374805, -78.6161327);
            mapa = new google.maps.Map(document.getElementById('zona_segura'), {
                center: centro,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            const marcador = new google.maps.Marker({
                position: centro,
                map: mapa,
                title: "Selecciona ubicación central",
                draggable: true
            });

            marcador.addListener('dragend', function (event) {
                document.getElementById('latitud').value = this.getPosition().lat();
                document.getElementById('longitud').value = this.getPosition().lng();
            });
        }

        function graficarZonaSegura() {
            const radio = parseFloat(document.getElementById('radio').value);
            const lat = parseFloat(document.getElementById('latitud').value);
            const lng = parseFloat(document.getElementById('longitud').value);

            const centro = new google.maps.LatLng(lat, lng);
            const mapaGrafico = new google.maps.Map(document.getElementById('mapa-circulo-zona'), {
                center: centro,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.SATELLITE
            });

            new google.maps.Marker({
                position: centro,
                map: mapaGrafico,
                title: "Centro"
            });

            new google.maps.Circle({
                strokeColor: "black",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "green",
                fillOpacity: 0.4,
                map: mapaGrafico,
                center: centro,
                radius: radio
            });
        }
    </script>

</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMapZona"></script>



@endsection
