@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('authors.index') }}" class="back-link">← Volver al listado</a>
    <h1>Editar Autor: {{ $author->name }}</h1>
</div>

<div class="card">
    <form action="{{ route('authors.update', $author) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Nombre del Autor</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $author->name) }}" required>
            @error('name') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Biografía</label>
            <textarea name="bio" class="form-control" rows="4">{{ old('bio', $author->bio) }}</textarea>
            @error('bio') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Autor</button>
            <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
