@extends('layouts.app')
@section('contenido')

<script>
    let zonas = @json($zonas);              // Zonas de riesgo
    let zonasSeguras = @json($zonasSeguras); // Zonas seguras
</script>

<h2 class="text-center">Mapa Global de Zonas</h2>

<div class="d-flex justify-content-between mb-3">
    <div>
        <label for="nivelFiltro" class="form-label"><b>Filtrar por nivel:</b></label>
        <select id="nivelFiltro" class="form-select" onchange="filtrarPorNivel()">
            <option value="todos">Todos</option>
            <option value="Bajo">Bajo</option>
            <option value="Medio">Medio</option>
            <option value="Alto">Alto</option>
        </select>
    </div>
</div>

<div id="mapa-zonas" style="height:600px; width:100%; border:2px solid blue;"></div>

<script>
    let mapa;
    let elementosGraficados = [];

    function initMap() {
        mapa = new google.maps.Map(document.getElementById('mapa-zonas'), {
            center: { lat: -0.9374805, lng: -78.6161327 },
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        filtrarPorNivel();
    }

    function limpiarMapa() {
        elementosGraficados.forEach(e => e.setMap(null));
        elementosGraficados = [];
    }

    function normalizarNivel(valor) {
        // Convierte 'Baja' a 'Bajo', etc.
        switch (valor.toLowerCase()) {
            case 'baja': return 'Bajo';
            case 'media': return 'Medio';
            case 'alta': return 'Alto';
            default: return valor;
        }
    }

    function obtenerColor(nivel) {
        switch (nivel) {
            case 'Bajo':  return '#44FF44'; // Verde
            case 'Medio': return '#FFB800'; // Amarillo
            case 'Alto':  return '#3399FF'; // Azul
            default:      return '#999999'; // Neutro
        }
    }

    function filtrarPorNivel() {
        limpiarMapa();
        const nivelFiltro = document.getElementById("nivelFiltro").value;

        zonas.forEach(z => {
            const nivelZona = normalizarNivel(z.nivelRiesgo || '');
            if (nivelFiltro === 'todos' || nivelZona === nivelFiltro) {
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
                    fillOpacity: 0.35,
                    map: mapa
                });

                elementosGraficados.push(poligono);
            }
        });

        zonasSeguras.forEach(z => {
            const nivelZona = normalizarNivel(z.tipo || '');
            if (nivelFiltro === 'todos' || nivelZona === nivelFiltro) {
                const centro = {
                    lat: parseFloat(z.latitud),
                    lng: parseFloat(z.longitud)
                };

                const color = obtenerColor(nivelZona);
                const radio = parseFloat(z.radio) || 50;

                const circulo = new google.maps.Circle({
                    strokeColor: "#000000",
                    strokeOpacity: 0.8,
                    strokeWeight: 2,
                    fillColor: color,
                    fillOpacity: 0.4,
                    map: mapa,
                    center: centro,
                    radius: radio
                });

                elementosGraficados.push(circulo);
            }
        });
    }
</script>

<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMap"></script>


@endsection

