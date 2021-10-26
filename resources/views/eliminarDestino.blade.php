@extends('layouts.plantilla')

    @section('contenido')
        <h1>Baja de un destino</h1>

        <div class="bg-light border-secondary col-6 mx-auto
                    shadow rounded p-4 text-danger">
            Se eliminará el destino:
            <span class="lead">{{ $destino->destNombre }}</span> | 
            {{ $destino->regNombre }}
            <form action="/eliminarDestino" method="post">
                @csrf
                <input type="hidden" name="destNombre"
                       value="{{ $destino->destNombre }}">
                <input type="hidden" name="destID"
                       value="{{ $destino->destID }}">
                <button class="btn btn-danger btn-block my-3">
                    Confirmar baja
                </button>
                <a href="/adminDestinos" class="btn btn-outline-secondary btn-block">
                    Volver a panel
                </a>
            </form>
        </div>
        <script>
            Swal.fire(
                'Advetencia!',
                'si pulsa el boton "confirmar baja", se eliminara el destino',
                'error'
            );
        </script>

    @endsection
