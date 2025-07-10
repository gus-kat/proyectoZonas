@extends('layouts.app')
@section('contenido')

<br><br><br>
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <h1 class="text-center">Listado de Zonas de Riesgo</h1>

        <a class="btn btn-warning mb-3" href="{{ route('zonasRiesgo.create') }}">Agregar Zona de Riesgo</a>

        <table id="tblZnR" class="table table-hover table-bordered table-striped text-center align-middle">
            <thead >
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
                    <td style="white-space: nowrap;">
                        <div class="d-flex justify-content-center gap-2">
                            <a class="btn btn-sm btn-warning" href="{{ route('zonasRiesgo.edit', $zona->id) }}"><i class="fas fa-edit"></i>Editar</a>
                            <form action="{{ route('zonasRiesgo.destroy', $zona->id) }}" method="POST" onsubmit="return confirm('¿Seguro deseas eliminar esta zona de Riesgo?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i> Eliminar</button>
                            </form>
                        </div>
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
        new DataTable('#tblZnR', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
            },
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

<br><br><br>
@endsection
