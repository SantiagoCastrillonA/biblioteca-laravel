@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Autores</h1>
    <a href="{{ route('authors.create') }}" class="btn btn-primary">+ Agregar Autor</a>
</div>

<div class="card">
    <table id="authorsTable" class="display table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Biografía</th>
                <th>Libros</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($authors as $author)
                <tr>
                    <td><strong>{{ $author->name }}</strong></td>
                    <td>{{ Str::limit($author->bio, 80) ?: '—' }}</td>
                    <td><span class="badge">{{ $author->books_count }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('authors.show', $author) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('authors.edit', $author) }}" class="btn btn-secondary">Editar</a>
                            <form action="{{ route('authors.destroy', $author) }}" method="POST" class="delete-form">
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
<script src="{{ asset('js/authors-index.js') }}"></script>
@endsection
