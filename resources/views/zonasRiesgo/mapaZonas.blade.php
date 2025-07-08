@extends('layouts.app')
@section('contenido')

<script>
    let zonas = @json($zonas);
</script>

<h2 class="text-center">Mapa de Zonas de Riesgo</h2>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-poligono" style="height:600px; width:100%; border:2px solid blue;"></div>
    </div>
</div>

<script>
    function initMap() {
        const mapa = new google.maps.Map(document.getElementById('mapa-poligono'), {
            center: { lat: -0.9374805, lng: -78.6161327 },
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const infoWindow = new google.maps.InfoWindow();

        zonas.forEach(z => {
            const coords = [
                { lat: parseFloat(z.latitud1), lng: parseFloat(z.longitud1) },
                { lat: parseFloat(z.latitud2), lng: parseFloat(z.longitud2) },
                { lat: parseFloat(z.latitud3), lng: parseFloat(z.longitud3) },
                { lat: parseFloat(z.latitud4), lng: parseFloat(z.longitud4) }
            ];

            const poligono = new google.maps.Polygon({
                paths: coords,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35
            });

            poligono.setMap(mapa);

            const centro = calcularCentroPoligono(coords);
            poligono.addListener('mouseover', () => {
                const contenido = `
                    <div>
                        <strong>Zona:</strong> ${z.nombre}<br>
                        <strong>Nivel de Riesgo:</strong> ${z.nivelRiesgo}<br>
                        <strong>Descripción:</strong> ${z.descripcion}
                    </div>`;
                infoWindow.setContent(contenido);
                infoWindow.setPosition(centro);
                infoWindow.open(mapa);
            });

            poligono.addListener('mouseout', () => {
                infoWindow.close();
            });
        });

        function calcularCentroPoligono(coords) {
            let lat = 0, lng = 0;
            coords.forEach(c => {
                lat += c.lat;
                lng += c.lng;
            });
            return { lat: lat / coords.length, lng: lng / coords.length };
        }
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMap"></script>

@endsection
