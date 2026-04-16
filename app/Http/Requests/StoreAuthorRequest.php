<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuthorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255|unique:authors,name',
            'bio' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del autor es obligatorio.',
            'name.unique' => 'Ya existe un autor con este nombre.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'bio.max' => 'La biografía no puede superar los 1000 caracteres.',
        ];
    }
}
