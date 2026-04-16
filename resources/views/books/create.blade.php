@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('books.index') }}" class="back-link">← Volver al listado</a>
    <h1>Agregar Nuevo Libro</h1>
</div>

<div class="card">
    <!-- Buscador de Open Library -->
    <div class="isbn-search-panel">
        <label class="form-label">🔍 Buscar en Open Library (ISBN)</label>
        <div class="isbn-search-row">
            <input type="text" id="isbn_search" class="form-control" placeholder="Ingresa ISBN (ej: 9780140328721)">
            <button type="button" id="btn_search_isbn" class="btn btn-primary">Cargar Datos</button>
        </div>
    </div>

    <form action="{{ route('books.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label class="form-label">Título del Libro</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Ej: Cien años de soledad">
            @error('title') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" value="{{ old('isbn') }}" required placeholder="Ej: 978-3-16-148410-0">
            @error('isbn') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="4" placeholder="Breve resumen del libro...">{{ old('description') }}</textarea>
            @error('description') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Fecha de Creación</label>
            <input type="date" name="published_at" id="published_at" class="form-control" value="{{ old('published_at') }}">
            @error('published_at') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">URL de la Portada</label>
            <input type="text" name="cover_url" id="cover_url" class="form-control" value="{{ old('cover_url') }}" placeholder="Auto-completado desde la API">
            <div id="cover_preview" class="cover-preview" style="display: none;">
                <p class="text-muted-sm">Previsualización:</p>
                <img id="preview_img" src="" class="cover-preview-img">
            </div>
            @error('cover_url') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Autores</label>
            <select name="authors[]" id="select-authors" class="form-control" multiple required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ collect(old('authors'))->contains($author->id) ? 'selected' : '' }}>
                        {{ $author->name }}
                    </option>
                @endforeach
            </select>
            @error('authors') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Categorías</label>
            <select name="categories[]" id="select-categories" class="form-control" multiple required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categories') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar Libro</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    window.searchIsbnUrl = "{{ route('books.search-isbn') }}";
    window.createBookUrl = "{{ route('books.create') }}";
</script>
<script src="{{ asset('js/books-create.js') }}"></script>
@endsection
