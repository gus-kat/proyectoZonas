@extends('layouts.app')
@section('contenido')
<div class="container mt-4">
    <form action="{{ route('puntos.update', $punto->id) }}" id="formEpuntos" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <h2 class="mb-4"><i class="fas fa-user-edit me-2"></i>Editar Punto de encuentro</h2>

        <div class="mb-3">
            <label for="nombre" class="form-label"><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $punto->nombre) }}">
        </div>

        <div class="mb-3">
            <label for="capacidad" class="form-label"><b>Capacidad:</b></label>
            <input type="text" name="capacidad" id="capacidad" class="form-control" value="{{ old('capacidad', $punto->capacidad) }}">
        </div>

        <div class="mb-3">
            <label for="responsable" class="form-label"><b>Responsable:</b></label>
            <input type="text" name="responsable" id="responsable" class="form-control" value="{{ old('responsable', $punto->responsable) }}">
        </div>

        <div class="mb-3">
            <label for="imagen" class="form-label"><b>imagen:</b></label>
            <input type="file" name="imagen" id="imagen" class="form-control" value="{{ old('imagen', $punto->imagen) }}">
        </div>

        

        <div class="mb-3">
            <label for="latitud" class="form-label"><b>Latitud:</b></label>
            <input type="text" name="latitud" id="latitud" class="form-control" value="{{ old('latitud', $punto->latitud) }}">
        </div>

        <div class="mb-3">
            <label for="longitud" class="form-label"><b>Longitud:</b></label>
            <input type="text" name="longitud" id="longitud" class="form-control" value="{{ old('longitud', $punto->longitud) }}">
        </div>

        <div class="mb-4">
            <label class="form-label"><b>Seleccionar ubicación:</b></label>
            <div id="mapa_cliente" style="border:1px solid #ccc; height:250px; width:100%;" class="rounded"></div>
        </div>
        
        <div class="my-2 text-end">
            <button type="button" style="color: blue;" class="btn btn-outline-dark btn-sm me-1" id="btnZoomIn">
                <i class="fas fa-search-plus"></i> Acercar
            </button>
            <button type="button" style="color: red;" class="btn btn-outline-dark btn-sm" id="btnZoomOut">
                <i class="fas fa-search-minus"></i> Alejar
            </button>
        </div>
        
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i>Actualizar
        </button>
        <a href="{{ route('puntos.index') }}" class="btn btn-secondary ms-2">
            <i class="fas fa-arrow-left me-1"></i>Cancelar
        </a>
    </form>
</div>

<script type="text/javascript">
    function initMap() {
        var lat = parseFloat(document.getElementById('latitud').value) || -0.9374805;
        var lng = parseFloat(document.getElementById('longitud').value) || -78.6161327;
        var latitud_longitud = new google.maps.LatLng(lat, lng);

        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: latitud_longitud,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marcador = new google.maps.Marker({
            position: latitud_longitud,
            map: mapa,
            title: "Seleccione la dirección",
            draggable: true
        });

        google.maps.event.addListener(marcador, 'dragend', function(event) {
            var latitud = this.getPosition().lat();
            var longitud = this.getPosition().lng();
            document.getElementById("latitud").value = latitud;
            document.getElementById("longitud").value = longitud;
        });

        document.getElementById('btnZoomIn').addEventListener('click', function () {
            const zoomActual = mapa.getZoom();
            mapa.setZoom(zoomActual + 1);
        });

        document.getElementById('btnZoomOut').addEventListener('click', function () {
            const zoomActual = mapa.getZoom();
            mapa.setZoom(zoomActual - 1);
        });

    }
</script>
<script>
    $("#formEpuntos").validate({
      rules: {
        nombre: {
          required: true,
          minlength: 3,
          maxlength: 40
        },
        capacidad: {
          required: true,
          min: 2,
          max: 60
        },
        responsable: {
          required: true,
          minlength: 4,
          maxlength: 20
        },
        latitud: {
          required: true,
          number: true,
          min: -90,
          max: 90
        },
        longitud: {
          required: true,
          number: true,
          min: -180,
          max: 180
        }
      },
      messages: {
        nombre: {
          required: "Por favor ingresa el nombre",
          minlength: "La cédula debe tener al menos 3 caracteres",
          maxlength: "La cédula no debe superar los 40 caracteres"
        },
        capacidad: {
          required: "Por favor ingresa una descripcion",
          min: "EL minimo de capacidad es 2",
          max: "El maximo de capacidad es 60"
        },
        responsable: {
          required: "Por favor ingresa la categoria",
          minlength: "El nombre debe tener al menos 4 caracteres",
          maxlength: "El nombre no debe superar los 20 caracteres"
        },
        latitud: {
          required: "Por favor ingresa la latitud",
          number: "La latitud debe ser un número",
          min: "La latitud mínima es -90",
          max: "La latitud máxima es 90"
        },
        longitud: {
          required: "Por favor ingresa la longitud",
          number: "La longitud debe ser un número",
          min: "La longitud mínima es -180",
          max: "La longitud máxima es 180"
        }
      }
    });
  </script>

  <script>
    $("#imagen").fileinput({
        showUpload: false,
        dropZoneEnabled: true,
        showCancel: false,
        theme: "fa",
        allowedFileExtensions: ["jpg", "jpeg", "png", "gif"],
        maxFileSize: 2048, // en KB (2 MB)
        msgPlaceholder: 'Seleccione una imagen...',
        browseLabel: 'Buscar imagen',
        removeLabel: 'Quitar',
        language: 'es'
    });
  </script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBuXfFTd694L_jf7x67Z5kAuv4IbtHnfFs&callback=initMap"></script>

@endsection
