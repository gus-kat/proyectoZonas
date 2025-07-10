@extends('layout.app')
@section('contenido')
<br>
<h1 >Mapa de los Puntos</h1> <!-- De este id que esta abajito-->
<br>
<div id="mapa-punto" 
    style="border:2px solid black; height:500px; whidth:100%;"
></div>|
<div class="my-2 text-end">
    <button type="button" style="color: blue;" class="btn btn-outline-dark btn-sm me-1" id="btnZoomIn">
        <i class="fas fa-search-plus"></i> Acercar
    </button>
    <button type="button" style="color: red;" class="btn btn-outline-dark btn-sm" id="btnZoomOut">
        <i class="fas fa-search-minus"></i> Alejar
    </button>
</div>

<script type="text/javascript">
    function initMap() {
        const centro = new google.maps.LatLng(-0.9374805, -78.6161327);
        const mapa = new google.maps.Map(document.getElementById('mapa-punto'), {
            center: centro,
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const infowindow = new google.maps.InfoWindow();

        @foreach($punto as $puntotemp)
            (function() {
                const coordenada = new google.maps.LatLng({{ $puntotemp->latitud }}, {{ $puntotemp->longitud }});

                const icono = {
                    url: "{{ asset('storage/' . $puntotemp->imagen) }}",
                    scaledSize: new google.maps.Size(65, 65), // ← Más grande
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(32, 65)
                };


                const marcador = new google.maps.Marker({
                    position: coordenada,
                    map: mapa,
                    icon: icono,
                    title: "{{ $puntotemp->nombre }}",
                    draggable: false
                });

                const contenido = `
                    <div style="max-width: 220px">
                        <h6><strong>{{ $puntotemp->nombre }}</strong></h6>
                        <p>{{ $puntotemp->descripcion }}</p>
                        <p><strong>Categoría:</strong> {{ $puntotemp->categoria }}</p>
                    </div>
                `;

                marcador.addListener('click', function() {
                    infowindow.setContent(contenido);
                    infowindow.open(mapa, marcador);
                });
                document.getElementById('btnZoomIn').addEventListener('click', function () {
                    const nivel = mapa.getZoom();
                    mapa.setZoom(nivel + 1);
                });

                document.getElementById('btnZoomOut').addEventListener('click', function () {
                    const nivel = mapa.getZoom();
                    mapa.setZoom(nivel - 1);
                });

            })();
        @endforeach
    }
</script>



@endsection