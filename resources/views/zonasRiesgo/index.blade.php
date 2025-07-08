@extends('layouts.app')
@section('contenido')
<<<<<<< HEAD

<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-10">

        <h1 class="text-center">Listado de Zonas de Riego</h1>

        <a class="btn btn-warning" href="{{ route('zonasRiesgo.create') }}">Agregar Zona de Riesgo</a>  <br> <br>

        <table id="tblZnR" class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Serie</th>
                    <th>Responsable</th>
                    <th>Nombres</th>
                    <th>Tipo</th>
                    <th>Radio</th>
                    <th>Latitud </th>
                    <th>Longitud </th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($zonas as $zona)
                <tr>
                    <td>{{ $zona->id }}</td>
                    <td>{{ $zona->serie }}</td>
                    <td>{{ $zona->responsable }}</td>
                    <td>{{ $zona->nombres }}</td>
                    <td>{{ $zona->tipo }}</td>
                    <td>{{ $zona->radio }}</td>
                    
                    <td>{{ $zona->latitud }}</td>
                    <td>{{ $zona->longitud }}</td>
                   
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
                url: 'https:cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            }
        });
    });
</script>
=======
<h1>AQUI ESTRAN LAS ZONAS DE RIESGO yayay </h1>
>>>>>>> f1d85acb508dfa1fb54569dcd2df6223bb85df7d
@endsection
