<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthorController extends Controller
{
    /**
     * lista todos los autores
     */
    public function index()
    {
        try {
            $authors = Author::withCount('books')->orderBy('name')->get();
            return view('authors.index', compact('authors'));
        } catch (\Exception $e) {
            Log::error('Error al cargar autores: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el listado de autores.');
        }
    }

    public function create()
    {
        return view('authors.create');
    }

    /**
     * guarda un nuevo autor en la base de datos
     */
    public function store(StoreAuthorRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Author::create($request->validated());
            });

            return redirect()->route('authors.index')->with('success', 'Autor creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear autor: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al crear el autor.');
        }
    }

    /**
     * muestra los detalles de un autor y sus libros
     */
    public function show(Author $author)
    {
        $author->load('books');
        return view('authors.show', compact('author'));
    }

    /**
     * muestra el formulario para editar un autor
     */
    public function edit(Author $author)
    {
        return view('authors.edit', compact('author'));
    }

    /**
     * actualiza los datos de un autor
     */
    public function update(UpdateAuthorRequest $request, Author $author)
    {
        try {
            DB::transaction(function () use ($request, $author) {
                $author->update($request->validated());
            });

            return redirect()->route('authors.index')->with('success', 'Autor actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar autor: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el autor.');
        }
    }

    /**
     * elimina un autor de la base de datos
     */
    public function destroy(Author $author)
    {
        try {
            DB::transaction(function () use ($author) {
                $author->books()->detach();
                $author->delete();
            });

            return redirect()->route('authors.index')->with('success', 'Autor eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar autor: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el autor.');
        }
    }
}
