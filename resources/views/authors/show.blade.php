@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('authors.index') }}" class="back-link">← Volver al listado</a>
    <h1>{{ $author->name }}</h1>
</div>

<div class="card">
    <div class="section">
        <h3 class="section-title">Biografía</h3>
        <p>{{ $author->bio ?: 'Sin biografía disponible.' }}</p>
    </div>

    @if($author->books->count() > 0)
    <div class="section">
        <h3 class="section-title">Libros ({{ $author->books->count() }})</h3>
        <div class="badge-list">
            @foreach($author->books as $book)
                <a href="{{ route('books.show', $book) }}" class="badge badge-author">{{ $book->title }}</a>
            @endforeach
        </div>
    </div>
    @else
    <p class="text-muted">Este autor no tiene libros registrados.</p>
    @endif

    <div class="card-footer">
        <a href="{{ route('authors.edit', $author) }}" class="btn btn-primary">Editar Autor</a>
        <form action="{{ route('authors.destroy', $author) }}" method="POST" onsubmit="return confirm('¿Seguro?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>
@endsection
