@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('categories.index') }}" class="back-link">← Volver al listado</a>
    <h1>Agregar Nueva Categoría</h1>
</div>

<div class="card">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Nombre de la Categoría</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Ej: Novela, Fantasía, Ciencia Ficción">
            @error('name') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Categoría</button>
            <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
