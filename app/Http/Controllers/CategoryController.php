<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Lista todas las categorías
     */
    public function index()
    {
        try {
            $categories = Category::withCount('books')->orderBy('name')->get();
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error al cargar categorías: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el listado de categorías.');
        }
    }

    /**
     * Muestra el formulario para crear una nueva categoría
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Guarda una nueva categoría en la base de datos
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Category::create($request->validated());
            });

            return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear categoría: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al crear la categoría.');
        }
    }

    /**
     * Muestra los detalles de una categoría y sus libros
     */
    public function show(Category $category)
    {
        $category->load('books');
        return view('categories.show', compact('category'));
    }

    /**
     * Muestra el formulario para editar una categoría
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Actualiza los datos de una categoría
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            DB::transaction(function () use ($request, $category) {
                $category->update($request->validated());
            });

            return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar categoría: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar la categoría.');
        }
    }

    /**
     * Elimina una categoría de la base de datos
     */
    public function destroy(Category $category)
    {
        try {
            DB::transaction(function () use ($category) {
                $category->books()->detach();
                $category->delete();
            });

            return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar categoría: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar la categoría.');
        }
    }
}
