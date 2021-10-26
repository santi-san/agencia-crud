@extends('layouts.plantilla')

@section('contenido')

    <h1>Modificacion de un destino</h1>

    <div class="bg-light border-secondary col-8 mx-auto shadow rounded p-4">

        <form action="/modificarDestino" method="post">
            @csrf
            Destino: <br>
            <input type="text" 
                name="destNombre" 
                value="{{ $destino->destNombre }}"    
                class="form-control" required>
            <input type="hidden" 
                    name="destID"
                    value="{{ $destino->destID }}">
            <br>
            Región: <br>
            <select name="regID" class="form-control" required>
                <option value="">Seleccione una región</option>
                @foreach( $regiones as $region )
                            <option {{ ( $destino->regID == $region->regID )?' selected':'' }} value="{{ $region->regID }}">{{ $region->regNombre }}</option>
                @endforeach
            </select>
            <br>
            Precio: <br>
            <input type="number" name="destPrecio" class="form-control" value="{{ $destino->destPrecio }}" required>
            <br>
            Asientos Totales: <br>
            <input type="number" name="destAsientos" class="form-control" value="{{ $destino->destAsientos }}" required>
            <br>
            Asientos Disponibles: <br>
            <input type="number" name="destDisponibles" class="form-control" value="{{ $destino->destDisponibles }}" required>
            <br>
            <button class="btn btn-dark">Modificar</button>
            <a href="/adminDestinos" class="btn btn-outline-secondary ml-3">
                Volver a panel
            </a>
        </form>

    </div>

@endsection
