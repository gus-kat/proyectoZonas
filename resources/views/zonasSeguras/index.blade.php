@extends('layouts.app')
@section('contenido')
<br><br><br>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <h1 class="text-center">Listado de Zonas Seguras</h1>

        <a class="btn btn-info" href="{{ route('zonasSeguras.create') }}">Agregar Zona Segura</a>  <br><br>

        <table id="tblZnSeguras" class="table table-hover table-bordered table-striped">
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
                        <a class="btn btn-warning btn-sm" href="{{ route('zonasSeguras.edit', $zona->id) }}">Editar</a>
                        <form action="{{ route('zonasSeguras.destroy', $zona->id) }}" method="POST" style="display:inline-block;" class="formEliminar">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" >Eliminar</button>
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
    $(document).ready(function () {
        $('#tblZnSeguras').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
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
