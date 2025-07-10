@extends('layouts.app')
@section('contenido')
<br><br><br>
<script>
    let zonas = @json($zonas);
</script>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('zonasRiesgo.store') }}" id="frmAgregarZona" method="post">
            @csrf
            <h3><b>Registrar Nueva Zona de Riesgo</b></h3>
            <hr>

            <label><b>Nombre de la Zona:</b></label>
            <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre..." required class="form-control"><br>

            <label><b>Descripción gogo:</b></label>
            <textarea name="descripcion" id="descripcion" rows="3" placeholder="Describa la zona..." class="form-control"></textarea><br>

            <label><b>Nivel de Riesgo:</b></label>
            <select name="nivelRiesgo" id="nivelRiesgo" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="Bajo">Bajo</option>
                <option value="Medio">Medio</option>
                <option value="Alto">Alto</option>
            </select><br>

            {{-- Coordenada 1 --}}
            <div class="row">
                <div class="col-md-5">
                    <label><b>COORDENADA N° 1</b></label><br>
                    <label>Latitud:</label>
                    <input type="number" name="latitud1" id="latitud1" class="form-control" readonly placeholder="Seleccione ..."><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud1" id="longitud1" class="form-control" readonly placeholder="Seleccione ...">
                </div>
                <div class="col-md-7">
                    <div id="mapa1" style="height:180px; width:100%; border:2px solid black;"></div>
                </div>
            </div><br>

            {{-- Coordenada 2 --}}
            <div class="row">
                <div class="col-md-5">
                    <label><b>COORDENADA N° 2</b></label><br>
                    <label>Latitud:</label>
                    <input type="number" name="latitud2" id="latitud2" class="form-control" readonly placeholder="Seleccione ..."><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud2" id="longitud2" class="form-control" readonly placeholder="Seleccione ...">
                </div>
                <div class="col-md-7">
                    <div id="mapa2" style="height:180px; width:100%; border:2px solid black;"></div>
                </div>
            </div><br>

            {{-- Coordenada 3 --}}
            <div class="row">
                <div class="col-md-5">
                    <label><b>COORDENADA N° 3</b></label><br>
                    <label>Latitud:</label>
                    <input type="number" name="latitud3" id="latitud3" class="form-control" readonly placeholder="Seleccione ..."><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud3" id="longitud3" class="form-control" readonly placeholder="Seleccione ...">
                </div>
                <div class="col-md-7">
                    <div id="mapa3" style="height:180px; width:100%; border:2px solid black;"></div>
                </div>
            </div><br>

            {{-- Coordenada 4 --}}
            <div class="row">
                <div class="col-md-5">
                    <label><b>COORDENADA N° 4</b></label><br>
                    <label>Latitud:</label>
                    <input type="number" name="latitud4" id="latitud4" class="form-control" readonly placeholder="Seleccione ..."><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud4" id="longitud4" class="form-control" readonly placeholder="Seleccione ...">
                </div>
                <div class="col-md-7">
                    <div id="mapa4" style="height:180px; width:100%; border:2px solid black;"></div>
                </div>
            </div><br>

            <center>
                <button class="btn btn-success">Guardar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="reset" class="btn btn-danger">Limpiar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('zonasRiesgo.index') }}" class="btn btn-primary">Ver Zonas de Riesgo</a>
            </center>
        </form>
    </div>
</div>

<br><br>

<h3 style="text-align: center;">Mapa con todas las Zonas de Riesgo Registradas</h3>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-poligono" style="height:500px; width:100%; border:2px solid blue;"></div>
    </div>
</div>

<script>
    function initMap() {
        const latlngInicial = { lat: -0.9374805, lng: -78.6161327 };

        function crearMapaYMarcador(idMapa, idLat, idLng, title) {
            const mapa = new google.maps.Map(document.getElementById(idMapa), {
                center: latlngInicial,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            const marcador = new google.maps.Marker({
                position: latlngInicial,
                map: mapa,
                title: title,
                draggable: true
            });
            marcador.addListener('dragend', function () {
                document.getElementById(idLat).value = this.getPosition().lat().toFixed(7);
                document.getElementById(idLng).value = this.getPosition().lng().toFixed(7);
                dibujarPoligono(); // Actualizar polígono al mover marcador
            });
            return marcador;
        }

        const marcador1 = crearMapaYMarcador('mapa1', 'latitud1', 'longitud1', 'Seleccione la coordenada 1');
        const marcador2 = crearMapaYMarcador('mapa2', 'latitud2', 'longitud2', 'Seleccione la coordenada 2');
        const marcador3 = crearMapaYMarcador('mapa3', 'latitud3', 'longitud3', 'Seleccione la coordenada 3');
        const marcador4 = crearMapaYMarcador('mapa4', 'latitud4', 'longitud4', 'Seleccione la coordenada 4');

        const mapaPoligono = new google.maps.Map(document.getElementById('mapa-poligono'), {
            center: latlngInicial,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const infoWindow = new google.maps.InfoWindow();

        zonas.forEach(z => {
            const coords = [
                { lat: parseFloat(z.latitud1), lng: parseFloat(z.longitud1) },
                { lat: parseFloat(z.latitud2), lng: parseFloat(z.longitud2) },
                { lat: parseFloat(z.latitud3), lng: parseFloat(z.longitud3) },
                { lat: parseFloat(z.latitud4), lng: parseFloat(z.longitud4) },
            ];

            const poligono = new google.maps.Polygon({
                paths: coords,
                strokeColor: "#FF0000",
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: "#FF0000",
                fillOpacity: 0.35,
            });

            poligono.setMap(mapaPoligono);

            const centro = calcularCentroPoligono(coords);

            poligono.addListener('mouseover', () => {
                const contenido = `
                    <div>
                        <strong>Zona:</strong> ${z.nombre}<br>
                        <strong>Nivel de Riesgo:</strong> ${z.nivelRiesgo}<br>
                        <strong>Descripción:</strong> ${z.descripcion}
                    </div>
                `;
                infoWindow.setContent(contenido);
                infoWindow.setPosition(centro);
                infoWindow.open(mapaPoligono);
            });
            poligono.addListener('mouseout', () => {
                infoWindow.close();
            });
        });

        function calcularCentroPoligono(coordenadas) {
            let lat = 0, lng = 0;
            coordenadas.forEach(c => {
                lat += c.lat;
                lng += c.lng;
            });
            return { lat: lat / coordenadas.length, lng: lng / coordenadas.length };
        }

        let poligonoActual = null;
        function dibujarPoligono() {
            const coords = [];
            ['latitud1','latitud2','latitud3','latitud4'].forEach((latId, i) => {
                const lngId = 'longitud' + (i+1);
                const lat = parseFloat(document.getElementById(latId).value);
                const lng = parseFloat(document.getElementById(lngId).value);
                if (!isNaN(lat) && !isNaN(lng)) {
                    coords.push({ lat, lng });
                }
            });
            if (coords.length === 4) {
                if (poligonoActual) {
                    poligonoActual.setMap(null);
                }
                poligonoActual = new google.maps.Polygon({
                    paths: coords,
                    strokeColor: "#0000FF",
                    strokeOpacity: 0.8,
                    strokeWeight: 3,
                    fillColor: "#0000FF",
                    fillOpacity: 0.3,
                });
                poligonoActual.setMap(mapaPoligono);
                mapaPoligono.fitBounds(getBoundsForCoords(coords));
            }
        }

        function getBoundsForCoords(coords) {
            const bounds = new google.maps.LatLngBounds();
            coords.forEach(c => bounds.extend(c));
            return bounds;
        }

        // Al cargar, dibujar polígono si hay valores
        dibujarPoligono();
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY_AQUI&callback=initMap"></script>

<script>
    $("#frmAgregarZona").validate({
        rules: {
            nombre: { required: true, minlength: 3 },
            nivelRiesgo: { required: true },
            latitud1: { required: true, number: true },
            longitud1: { required: true, number: true },
            latitud2: { required: true, number: true },
            longitud2: { required: true, number: true },
            latitud3: { required: true, number: true },
            longitud3: { required: true, number: true },
            latitud4: { required: true, number: true },
            longitud4: { required: true, number: true },
        },
        messages: {
            nombre: { required: "Ingrese el nombre de la zona", minlength: "Mínimo 3 caracteres" },
            nivelRiesgo: { required: "Seleccione el nivel de riesgo" },
            latitud1: { required: "Latitud 1 obligatoria", number: "Número inválido" },
            longitud1: { required: "Longitud 1 obligatoria", number: "Número inválido" },
            latitud2: { required: "Latitud 2 obligatoria", number: "Número inválido" },
            longitud2: { required: "Longitud 2 obligatoria", number: "Número inválido" },
            latitud3: { required: "Latitud 3 obligatoria", number: "Número inválido" },
            longitud3: { required: "Longitud 3 obligatoria", number: "Número inválido" },
            latitud4: { required: "Latitud 4 obligatoria", number: "Número inválido" },
            longitud4: { required: "Longitud 4 obligatoria", number: "Número inválido" },
        }
    });
</script>
<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMap"></script>

<br><br><br>

@endsection


