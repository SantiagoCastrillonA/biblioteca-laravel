@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('authors.index') }}" class="back-link">← Volver al listado</a>
    <h1>Agregar Nuevo Autor</h1>
</div>

<div class="card">
    <form action="{{ route('authors.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Nombre del Autor</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Ej: Gabriel García Márquez">
            @error('name') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Biografía</label>
            <textarea name="bio" class="form-control" rows="4" placeholder="Breve biografía del autor...">{{ old('bio') }}</textarea>
            @error('bio') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Autor</button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
