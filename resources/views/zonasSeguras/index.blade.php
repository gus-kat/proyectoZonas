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
                        <form action="{{ route('zonasSeguras.destroy', $zona->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro deseas eliminar esta zona segura?')">Eliminar</button>
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
<br><br><br>
@endsection
