@extends('layouts.app')
@section('contenido')
<br><br><br>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <h1 class="text-center">Listado de Zonas Seguras</h1>

        <a class="btn btn-info" href="{{ route('zonasSeguras.create') }}">Agregar Zona Segura</a>  <br><br>

        <table  class="table table-hover table-bordered table-striped" id="tablaZsegura">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Radio</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Tipo de Seguridad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->radio }} m</td>
                    <td>{{ $zona->latitud }}</td>
                    <td>{{ $zona->longitud }}</td>
                    <td>{{ $zona->tipo }}</td>
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('zonasSeguras.edit', $zona->id) }}"><i class="fas fa-edit"></i>Editar</a>
                        <form action="{{ route('zonasSeguras.destroy', $zona->id) }}" method="POST" style="display:inline-block;" class="formEliminar">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" ><i class="fas fa-trash-alt"></i> Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="col-md-1"></div>
</div>


<script>
// Inicializar DataTable
    $(document).ready(function () {
      let table = new DataTable('#tablaZsegura', {
        
        language: {
          url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
        },
        dom: '<"top d-flex justify-content-between"fB>rtp',
        dom: "<'d-flex justify-content-between align-items-center mb-3'Bf>rtip",
        pageLength: 5,
        
        buttons: [
          { extend: 'copy', text: 'Copiar', className: 'btn btn-primary me-2' },
          { extend: 'csv', text: 'CSV', className: 'btn btn-info me-2' },
          { extend: 'excel', text: 'Excel', className: 'btn btn-success me-2' },
          { extend: 'pdf', text: 'PDF', className: 'btn btn-danger me-2' },
          { extend: 'print', text: 'Imprimir', className: 'btn btn-secondary me-2' }
        ]

      });
    });
  </script>

<!-- Confirmación con SweetAlert -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formularios = document.querySelectorAll('.formEliminar');

    formularios.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "¿Estás seguro?",
                text: "Una vez eliminado no se puede recuperar",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); 
                }
            });
        });
    });
});
</script>
<br><br><br>
@endsection
