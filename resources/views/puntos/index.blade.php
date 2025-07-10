@extends('layouts.app')
@section('contenido')
<br><br><br>
<div class="container mt-4"><br>
    
    <a href="{{ route('puntos.create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-user-plus me-1"></i> Agregar punto
    </a>
    <br>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CAPACIDAD</th>
                <th>RESPONSABLE</th>
                <th>IMAGEN</th> <!-- columna para la imagen -->
                <th>latitud</th>
                <th>longitud</th>
                <th>acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($punto as $puntotemp)
            <tr>
                <td>{{ $puntotemp->id }}</td>
                <td>{{ $puntotemp->nombre }}</td>
                <td>{{ $puntotemp->capacidad }}</td>
                <td>{{ $puntotemp->responsable }}</td>
                <td>
                    @if($puntotemp->imagen && $puntotemp->imagen !== 'sin imagen')
                        <img src="{{ asset('storage/' . $puntotemp->imagen) }}" alt="Imagen Punto" width="100" height="80" style="object-fit: cover; border-radius: 5px;">
                    @else
                        <span>No hay imagen</span>
                    @endif
                </td>

                <td>{{ $puntotemp->latitud }}</td>
                <td>{{ $puntotemp->longitud }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ route('puntos.edit', $puntotemp->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Editar
                        </a>

                    <form action="{{ route('puntos.destroy', $puntotemp->id) }}" method="POST" class="formEliminar">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i> Eliminar
                        </button>
                    </form>

                    </div>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
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
