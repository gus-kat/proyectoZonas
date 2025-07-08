@extends('layouts.app')
@section('contenido')

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <h1 class="text-center">Listado de Zonas de Riesgo</h1>

        <a class="btn btn-warning" href="{{ route('zonasRiesgo.create') }}">Agregar Zona de Riesgo</a>  <br><br>

        <table id="tblZnR" class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Nivel de Riesgo</th>
                    <th>Lat1</th>
                    <th>Lng1</th>
                    <th>Lat2</th>
                    <th>Lng2</th>
                    <th>Lat3</th>
                    <th>Lng3</th>
                    <th>Lat4</th>
                    <th>Lng4</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->nombre }}</td>
                    <td>{{ $zona->descripcion }}</td>
                    <td>{{ $zona->nivelRiesgo }}</td>
                    <td>{{ $zona->latitud1 }}</td>
                    <td>{{ $zona->longitud1 }}</td>
                    <td>{{ $zona->latitud2 }}</td>
                    <td>{{ $zona->longitud2 }}</td>
                    <td>{{ $zona->latitud3 }}</td>
                    <td>{{ $zona->longitud3 }}</td>
                    <td>{{ $zona->latitud4 }}</td>
                    <td>{{ $zona->longitud4 }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('zonasRiesgo.edit', $zona->id) }}">Editar</a>
                        <form action="{{ route('zonasRiesgo.destroy', $zona->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" onclick="return confirm('¿Seguro deseas eliminar esta zona de Riesgo?')">Eliminar</button>
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
        $('#tblZnR').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
</script>

@endsection
