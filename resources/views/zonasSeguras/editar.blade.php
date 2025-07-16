@extends('layouts.app')
@section('contenido')
<br><br><br>
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6 bg-light" style="color:black">
    <h1 class="text-center">Editar Zona Segura</h1>

    <form action="{{ route('zonasSeguras.update', $zona->id) }}" method="POST" id="frm_editar_zona_segura">
        @csrf
        @method('PUT')

        <label for="nombre">Nombre</label><br>
        <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $zona->nombre }}"><br>

        <label for="radio">Radio</label><br>
        <input type="number" name="radio" id="radio" class="form-control" value="{{ $zona->radio }}"><br>

        <label for="tipo">Nivel de Seguridad</label><br>
        <select name="tipo" id="tipo" class="form-control">
            <option value="Baja"  {{ trim($zona->tipo) == 'Baja'  ? 'selected' : '' }}>Baja</option>
            <option value="Media" {{ trim($zona->tipo) == 'Media' ? 'selected' : '' }}>Media</option>
            <option value="Alta"  {{ trim($zona->tipo) == 'Alta'  ? 'selected' : '' }}>Alta</option>
        </select><br>

        <div class="row">
            <div class="col-md-6">
                <label for="latitud">Latitud</label>
                <input type="text" name="latitud" id="latitud" class="form-control" value="{{ $zona->latitud }}">
            </div>
            <div class="col-md-6">
                <label for="longitud">Longitud</label>
                <input type="text" name="longitud" id="longitud" class="form-control" value="{{ $zona->longitud }}">
            </div>
        </div><br>

        <div id="mapa_editar_zona" style="border:2px solid black; height:300px; width:100%;"></div><br>

        <button class="btn btn-warning">Actualizar</button>
        <a href="{{ route('zonasSeguras.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<script>
    let mapa, marcador, circulo;

    function getColorPorNivel(nivel) {
        switch (nivel.trim()) {
            case 'Baja': return "#44FF44";  // Verde
            case 'Media': return "#FFB800"; // Amarillo
            case 'Alta': return "#3399FF";  // Azul
            default: return "#999999";      // Gris neutro
        }
    }

    function initMapZonaEditar() {
        const lat   = parseFloat(document.getElementById('latitud').value);
        const lng   = parseFloat(document.getElementById('longitud').value);
        const radio = parseFloat(document.getElementById('radio').value) || 50;
        const tipo  = document.getElementById('tipo').value.trim();
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

        // Evento al mover el marcador
        marcador.addListener('dragend', function () {
            const nuevaPos = this.getPosition();
            document.getElementById('latitud').value  = nuevaPos.lat();
            document.getElementById('longitud').value = nuevaPos.lng();
            circulo.setCenter(nuevaPos);
        });

        // Actualiza radio en tiempo real
        document.getElementById('radio').addEventListener('input', function () {
            circulo.setRadius(parseFloat(this.value));
        });

        // Actualiza color en tiempo real
        document.getElementById('tipo').addEventListener('change', function () {
            const nuevoColor = getColorPorNivel(this.value);
            circulo.setOptions({ fillColor: nuevoColor });
        });
    }

    // Ejecutar mapa cuando la API esté lista
    if (typeof google !== 'undefined') {
        google.maps.event.addDomListener(window, 'load', initMapZonaEditar);
    } else {
        window.initMapZonaEditar = initMapZonaEditar;
    }
</script>
<script>
    $("#frm_editar_zona_segura").validate({
        rules: {
                nombre: {
                    required: true,
                    minlength: 3
                },
                radio: {
                    required: true,
                    number: true,
                    min: 1
                },
                tipo: {
                    required: true
                },
                latitud: {
                    required: true,
                    number: true
                },
                longitud: {
                    required: true,
                    number: true
                }
            },
            messages: {
                nombre: {
                    required: "Ingrese el nombre descriptivo",
                    minlength: "Mínimo 3 caracteres"
                },
                radio: {
                    required: "Ingrese el radio de seguridad",
                    number: "Debe ser un número válido",
                    min: "El radio debe ser mayor a cero"
                },
                tipo: {
                    required: "Seleccione el nivel de seguridad"
                },
                latitud: {
                    required: "Seleccione la ubicación en el mapa",
                    number: "Latitud inválida"
                },
                longitud: {
                    required: "Seleccione la ubicación en el mapa",
                    number: "Longitud inválida"
                }
            },
            errorClass: "is-invalid",
            validClass: "is-valid",
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            }
        });
</script>

<!-- Google Maps API -->
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMapZona"></script>
<br><br><br>
@endsection
