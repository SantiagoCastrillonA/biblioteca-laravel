@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Catálogo de Libros</h1>
    <a href="{{ route('books.create') }}" class="btn btn-primary">+ Agregar Libro</a>
</div>

<div class="card">
    <table id="booksTable" class="display table">
        <thead>
            <tr>
                <th>Portada</th>
                <th>Título</th>
                <th>ISBN</th>
                <th>Autores</th>
                <th>Categorías</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>
                        @if($book->cover_url)
                            <img src="{{ $book->cover_url }}" class="cover-thumb">
                        @else
                            <span class="text-muted-sm">N/A</span>
                        @endif
                    </td>
                    <td><strong>{{ $book->title }}</strong></td>
                    <td><code>{{ $book->isbn }}</code></td>
                    <td>
                        @foreach($book->authors as $author)
                            <span class="badge">{{ $author->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach($book->categories as $category)
                            <span class="badge">{{ $category->name }}</span>
                        @endforeach
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('books.show', $book) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('books.edit', $book) }}" class="btn btn-secondary">Editar</a>
                            <form action="{{ route('books.destroy', $book) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/books-index.js') }}"></script>
@endsection
