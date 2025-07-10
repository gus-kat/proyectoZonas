@extends('layouts.app')
@section('contenido')
<br><br><br>
<script>
    
    let zona = @json($zona);
</script>

<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <form action="{{ route('zonasRiesgo.update', $zona->id) }}" id="frmEditarZona" method="post">
            @csrf
            @method('PUT')

            <h3><b>Editar Zona de Riesgo</b></h3>
            <hr>

            <label><b>Nombre de la Zona:</b></label>
            <input type="text" name="nombre" id="nombre" placeholder="Ingrese el nombre..." required class="form-control" value="{{ old('nombre', $zona->nombre) }}"><br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" id="descripcion" rows="3" placeholder="Describa la zona..." class="form-control">{{ old('descripcion', $zona->descripcion) }}</textarea><br>

            <label><b>Nivel de Riesgo:</b></label>
            <select name="nivelRiesgo" id="nivelRiesgo" class="form-control" required>
                <option value="">Seleccione</option>
                <option value="Bajo" {{ old('nivelRiesgo', $zona->nivelRiesgo) == 'Bajo' ? 'selected' : '' }}>Bajo</option>
                <option value="Medio" {{ old('nivelRiesgo', $zona->nivelRiesgo) == 'Medio' ? 'selected' : '' }}>Medio</option>
                <option value="Alto" {{ old('nivelRiesgo', $zona->nivelRiesgo) == 'Alto' ? 'selected' : '' }}>Alto</option>
            </select><br>

            {{-- Coordenada 1 --}}
            <div class="row">
                <div class="col-md-5">
                    <label><b>COORDENADA N° 1</b></label><br>
                    <label>Latitud:</label>
                    <input type="number" name="latitud1" id="latitud1" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('latitud1', $zona->latitud1) }}"><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud1" id="longitud1" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('longitud1', $zona->longitud1) }}">
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
                    <input type="number" name="latitud2" id="latitud2" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('latitud2', $zona->latitud2) }}"><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud2" id="longitud2" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('longitud2', $zona->longitud2) }}">
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
                    <input type="number" name="latitud3" id="latitud3" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('latitud3', $zona->latitud3) }}"><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud3" id="longitud3" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('longitud3', $zona->longitud3) }}">
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
                    <input type="number" name="latitud4" id="latitud4" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('latitud4', $zona->latitud4) }}"><br>
                    <label>Longitud:</label>
                    <input type="number" name="longitud4" id="longitud4" class="form-control" readonly placeholder="Seleccione ..." value="{{ old('longitud4', $zona->longitud4) }}">
                </div>
                <div class="col-md-7">
                    <div id="mapa4" style="height:180px; width:100%; border:2px solid black;"></div>
                </div>
            </div><br>

            <center>
                <button class="btn btn-success">Actualizar</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('zonasRiesgo.index') }}" class="btn btn-primary">Volver al listado</a>
            </center>
        </form>
    </div>
</div>

<script>
    function initMap() {
        // Si la zona tiene lat/lng, los usamos, sino centro por defecto
        const latlngInicial1 = {
            lat: zona.latitud1 ? parseFloat(zona.latitud1) : -0.9374805,
            lng: zona.longitud1 ? parseFloat(zona.longitud1) : -78.6161327
        };
        const latlngInicial2 = {
            lat: zona.latitud2 ? parseFloat(zona.latitud2) : -0.9374805,
            lng: zona.longitud2 ? parseFloat(zona.longitud2) : -78.6161327
        };
        const latlngInicial3 = {
            lat: zona.latitud3 ? parseFloat(zona.latitud3) : -0.9374805,
            lng: zona.longitud3 ? parseFloat(zona.longitud3) : -78.6161327
        };
        const latlngInicial4 = {
            lat: zona.latitud4 ? parseFloat(zona.latitud4) : -0.9374805,
            lng: zona.longitud4 ? parseFloat(zona.longitud4) : -78.6161327
        };

        function crearMapaYMarcador(idMapa, idLat, idLng, posicionInicial, title) {
            const mapa = new google.maps.Map(document.getElementById(idMapa), {
                center: posicionInicial,
                zoom: 15,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });
            const marcador = new google.maps.Marker({
                position: posicionInicial,
                map: mapa,
                title: title,
                draggable: true
            });
            marcador.addListener('dragend', function () {
                document.getElementById(idLat).value = this.getPosition().lat().toFixed(7);
                document.getElementById(idLng).value = this.getPosition().lng().toFixed(7);
            });
            return marcador;
        }

        crearMapaYMarcador('mapa1', 'latitud1', 'longitud1', latlngInicial1, 'Coordenada 1');
        crearMapaYMarcador('mapa2', 'latitud2', 'longitud2', latlngInicial2, 'Coordenada 2');
        crearMapaYMarcador('mapa3', 'latitud3', 'longitud3', latlngInicial3, 'Coordenada 3');
        crearMapaYMarcador('mapa4', 'latitud4', 'longitud4', latlngInicial4, 'Coordenada 4');
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY_AQUI&callback=initMap">
</script>

<script>
    $("#frmEditarZona").validate({
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
