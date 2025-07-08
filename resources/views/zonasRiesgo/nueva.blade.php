@extends('layouts.app')
@section('contenido')

<script>
    let zonas = @json($zonas); // En el controlador deberías pasar $zonas = ZonaRiesgo::all();
</script>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('zonas.store') }}" id="frmAgregarZona" method="post">
            @csrf
            <h3><b>Registrar Nueva Zona de Riesgo</b></h3>
            <hr>
            <label><b>Nombre de la Zona:</b></label>
            <input type="text" name="nombre" class="form-control" placeholder="Ingrese el nombre..." required><br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" class="form-control" rows="3" placeholder="Describa la zona..."></textarea><br>

            <label><b>Nivel de Riesgo:</b></label>
            <select name="nivelRiego" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="Bajo">Bajo</option>
                <option value="Medio">Medio</option>
                <option value="Alto">Alto</option>
            </select><br>

            <label><b>Coordenadas</b></label>
            <div class="row">
                <div class="col-md-6">
                    <label>Latitud:</label>
                    <input type="number" step="any" name="latitud" id="latitud" class="form-control" readonly>
                </div>
                <div class="col-md-6">
                    <label>Longitud:</label>
                    <input type="number" step="any" name="longitud" id="longitud" class="form-control" readonly>
                </div>
            </div>
            <br>
            <div id="mapa" style="height: 300px; width: 100%; border: 2px solid black;"></div>
            <br>

            <center>
                <button class="btn btn-success">Guardar</button>
                <button type="reset" class="btn btn-danger">Limpiar</button>
                <a href="{{ route('zonas.index') }}" class="btn btn-primary">Ver Zonas</a>
            </center>
        </form>
    </div>
</div>

<br><br>
<h3 style="text-align: center;">Mapa de Zonas Registradas</h3>
<div class="row">
    <div class="col-md-12">
        <div id="mapa-zonas" style="height: 500px; width: 100%; border: 2px solid blue;"></div>
    </div>
</div>

<script>
    function initMap() {
        const centroMapa = { lat: -0.9374805, lng: -78.6161327 };

        const mapaPrincipal = new google.maps.Map(document.getElementById('mapa'), {
            center: centroMapa,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const marcador = new google.maps.Marker({
            position: centroMapa,
            map: mapaPrincipal,
            draggable: true,
            title: "Ubique la zona de riesgo"
        });

        // Actualiza campos al mover el marcador
        marcador.addListener('dragend', function () {
            const pos = this.getPosition();
            document.getElementById('latitud').value = pos.lat();
            document.getElementById('longitud').value = pos.lng();
        });

        // Mapa de Zonas existentes
        const mapaZonas = new google.maps.Map(document.getElementById('mapa-zonas'), {
            center: centroMapa,
            zoom: 14,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        const infoWindow = new google.maps.InfoWindow();

        zonas.forEach(z => {
            const posicion = { lat: parseFloat(z.latitud), lng: parseFloat(z.longitud) };

            const marker = new google.maps.Marker({
                position: posicion,
                map: mapaZonas,
                title: z.nombre,
                icon: {
                    url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                }
            });

            marker.addListener('mouseover', () => {
                infoWindow.setContent(`
                    <strong>${z.nombre}</strong><br>
                    Nivel de Riesgo: ${z.nivelRiego}<br>
                    ${z.descripcion}
                `);
                infoWindow.open(mapaZonas, marker);
            });

            marker.addListener('mouseout', () => {
                infoWindow.close();
            });
        });
    }
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY&callback=initMap" async defer></script>

@endsection
