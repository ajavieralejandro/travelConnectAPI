@extends('layouts.admin')
@section('content')
<div class="container">
    <h2 class="mb-4">Crear Nuevo Paquete</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form  method="POST">
        @csrf

        <div class="mb-3">
            <label for="agencia_id" class="form-label">Agencia</label>
            <select name="agencia_id" id="agencia_id" class="form-control" required>
                <option value="">Seleccione una agencia</option>
                @foreach ($agencias as $agencia)
                    <option value="{{ $agencia->id }}">{{ $agencia->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" id="titulo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="subtitulo" class="form-label">Subtítulo</label>
            <input type="text" name="subtitulo" id="subtitulo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="destino" class="form-label">Destino</label>
            <input type="text" name="destino" id="destino" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="noches" class="form-label">Noches</label>
            <input type="number" name="noches" id="noches" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="regimen" class="form-label">Régimen</label>
            <input type="text" name="regimen" id="regimen" class="form-control">
        </div>

        <div class="mb-3">
            <label for="vuelo" class="form-label">Vuelo</label>
            <input type="text" name="vuelo" id="vuelo" class="form-control">
        </div>

        <div class="mb-3">
            <label for="precio_desde" class="form-label">Precio Desde</label>
            <input type="number" name="precio_desde" id="precio_desde" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="vigencia" class="form-label">Vigencia</label>
            <input type="date" name="vigencia" id="vigencia" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control">
        </div>

        <div class="mb-3">
            <label for="multiples_fechas" class="form-label">Múltiples Fechas</label>
            <select name="multiples_fechas" id="multiples_fechas" class="form-control">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" id="estado" class="form-control">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="hotel" class="form-label">Hotel</label>
            <input type="text" name="hotel" id="hotel" class="form-control">
        </div>

        <div class="mb-3">
            <label for="estrellas" class="form-label">Estrellas</label>
            <input type="number" name="estrellas" id="estrellas" class="form-control">
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Paquete</button>
    </form>
</div>
@endsection