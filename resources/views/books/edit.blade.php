@extends('layouts.app')

@section('content')
<div class="page-back">
    <a href="{{ route('books.index') }}" class="back-link">← Volver al listado</a>
    <h1>Editar Libro: {{ $book->title }}</h1>
</div>

<div class="card">
    <form action="{{ route('books.update', $book) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label class="form-label">Título del Libro</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
            @error('title') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">ISBN</label>
            <input type="text" name="isbn" class="form-control" value="{{ old('isbn', $book->isbn) }}" required>
            @error('isbn') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Descripción</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $book->description) }}</textarea>
            @error('description') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Fecha de Creación</label>
            <input type="date" name="published_at" class="form-control" value="{{ old('published_at', $book->published_at ? \Carbon\Carbon::parse($book->published_at)->format('Y-m-d') : '') }}">
            @error('published_at') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">URL de la Portada</label>
            <input type="text" name="cover_url" id="cover_url_edit" class="form-control" value="{{ old('cover_url', $book->cover_url) }}" placeholder="URL de la imagen de portada">
            <div id="cover_preview_edit" class="cover-preview" {!! $book->cover_url ? '' : 'style="display: none;"' !!}>
                <p class="text-muted-sm">Previsualización:</p>
                <img id="preview_img_edit" src="{{ $book->cover_url }}" class="cover-preview-img">
            </div>
            @error('cover_url') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Autores</label>
            <select name="authors[]" id="select-authors" class="form-control" multiple required>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}"
                        {{ collect(old('authors', $book->authors->pluck('id')->toArray()))->contains($author->id) ? 'selected' : '' }}>
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
                    <option value="{{ $category->id }}"
                        {{ collect(old('categories', $book->categories->pluck('id')->toArray()))->contains($category->id) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categories') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Actualizar Libro</button>
            <a href="{{ route('books.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/books-edit.js') }}"></script>
@endsection
