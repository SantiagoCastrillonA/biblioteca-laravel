@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('categories.index') }}" class="back-link">← Volver al listado</a>
    <h1>{{ $category->name }}</h1>
</div>

<div class="card">
    @if($category->books->count() > 0)
    <div class="section">
        <h3 class="section-title">Libros en esta categoría ({{ $category->books->count() }})</h3>
        <div class="badge-list">
            @foreach($category->books as $book)
                <a href="{{ route('books.show', $book) }}" class="badge badge-category">{{ $book->title }}</a>
            @endforeach
        </div>
    </div>
    @else
    <p class="text-muted">No hay libros en esta categoría.</p>
    @endif

    <div class="card-footer">
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Editar Categoría</a>
        <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('¿Seguro?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Eliminar</button>
        </form>
    </div>
</div>
@endsection
