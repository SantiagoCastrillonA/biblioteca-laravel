@extends('layouts.app')

@section('content')
<div class="page-header">
    <h1>Categorías</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Agregar Categoría</a>
</div>

<div class="card">
    <table id="categoriesTable" class="display table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Libros</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td><span class="badge">{{ $category->books_count }}</span></td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ route('categories.show', $category) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('categories.edit', $category) }}" class="btn btn-secondary">Editar</a>
                            <form action="{{ route('categories.destroy', $category) }}" method="POST" class="delete-form">
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
<script src="{{ asset('js/categories-index.js') }}"></script>
@endsection
