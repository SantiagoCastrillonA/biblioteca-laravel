<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado para esta solicitud.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para actualizar un libro.
     */
    public function rules(): array
    {
        $bookId = $this->route('book')->id;

        return [
            'title' => 'required|string|max:255',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $bookId,
            'description' => 'nullable|string',
            'published_at' => 'nullable|date',
            'cover_url' => 'nullable|url|max:500',
            'authors' => 'required|array|min:1',
            'authors.*' => 'exists:authors,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'El título del libro es obligatorio.',
            'title.max' => 'El título no puede superar los 255 caracteres.',
            'isbn.required' => 'El ISBN es obligatorio.',
            'isbn.unique' => 'Este ISBN ya está registrado en el sistema.',
            'authors.required' => 'Debe seleccionar al menos un autor.',
            'authors.min' => 'Debe seleccionar al menos un autor.',
            'categories.required' => 'Debe seleccionar al menos una categoría.',
            'categories.min' => 'Debe seleccionar al menos una categoría.',
            'cover_url.url' => 'La URL de la portada no es válida.',
        ];
    }
}
