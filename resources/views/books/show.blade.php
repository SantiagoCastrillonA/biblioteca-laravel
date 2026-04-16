@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('books.index') }}" class="back-link">← Volver al listado</a>
    <h1>Detalles del Libro</h1>
</div>

<div class="card">
    <div class="book-header">
        @if($book->cover_url)
            <img src="{{ $book->cover_url }}" class="cover-large">
        @endif
        <div>
            <h2 class="book-title">{{ $book->title }}</h2>
            <p class="text-muted">ISBN: <code>{{ $book->isbn }}</code></p>
        </div>
    </div>

    <div class="section">
        <h3 class="section-title">Descripción</h3>
        <p>{{ $book->description ?: 'Sin descripción disponible.' }}</p>
    </div>

    <div class="detail-grid">
        <div>
            <h3 class="section-title">Autores</h3>
            @foreach($book->authors as $author)
                <span class="badge badge-author">{{ $author->name }}</span>
            @endforeach
        </div>
        <div>
            <h3 class="section-title">Categorías</h3>
            @foreach($book->categories as $category)
                <span class="badge badge-category">{{ $category->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('books.edit', $book) }}" class="btn btn-primary">Editar Libro</a>
        <form action="{{ route('books.destroy', $book) }}" method="POST" class="delete-form">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>
@endsection
