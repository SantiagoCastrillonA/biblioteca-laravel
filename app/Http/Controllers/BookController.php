<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Lista todos los libros con sus relaciones
     */
    public function index()
    {
        try {
            $books = Book::with('authors', 'categories')->latest()->get();
            return view('books.index', compact('books'));
        } catch (\Exception $e) {
            Log::error('Error al cargar libros: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error al cargar el catálogo de libros.');
        }
    }

    /**
     * Muestra el formulario para crear un nuevo libro
     */
    public function create()
    {
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('authors', 'categories'));
    }

    /**
     * Guarda un nuevo libro en la base de datos
     */
    public function store(StoreBookRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $book = Book::create($request->validated());
                $book->authors()->sync($request->authors);
                $book->categories()->sync($request->categories);
            });

            return redirect()->route('books.index')->with('success', 'Libro creado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al crear libro: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al crear el libro. Intente nuevamente.');
        }
    }

    /**
     * Muestra los detalles de un libro en específico
     */
    public function show(Book $book)
    {
        $book->load(['authors', 'categories']);
        return view('books.show', compact('book'));
    }

    /**
     * Muestra el formulario para editar un libro existente
     */
    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $book->load(['authors', 'categories']);
        return view('books.edit', compact('book', 'authors', 'categories'));
    }

    /**
     * Actualiza los datos de un libro en la base de datos
     */
    public function update(UpdateBookRequest $request, Book $book)
    {
        try {
            DB::transaction(function () use ($request, $book) {
                $book->update($request->validated());
                $book->authors()->sync($request->authors);
                $book->categories()->sync($request->categories);
            });

            return redirect()->route('books.index')->with('success', 'Libro actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar libro: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Ocurrió un error al actualizar el libro. Intente nuevamente.');
        }
    }

    /**
     * Elimina un libro de la base de datos
     */
    public function destroy(Book $book)
    {
        try {
            DB::transaction(function () use ($book) {
                $book->authors()->detach();
                $book->categories()->detach();
                $book->delete();
            });

            return redirect()->route('books.index')->with('success', 'Libro eliminado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar libro: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al eliminar el libro.');
        }
    }

    /**
     * Busca información de un libro en Open Library por su ISBN
     */
    public function searchByIsbn(Request $request)
    {
        try {
            $isbn = $request->isbn;
            if (!$isbn) {
                return response()->json(['error' => 'ISBN requerido'], 400);
            }

            $response = Http::timeout(10)->get("https://openlibrary.org/api/books", [
                'bibkeys' => "ISBN:$isbn",
                'format' => 'json',
                'jscmd' => 'data'
            ]);

            if (!$response->successful()) {
                return response()->json(['error' => 'Error al conectar con Open Library'], 503);
            }

            $data = $response->json();
            $bookKey = "ISBN:$isbn";
            $bookData = $data[$bookKey] ?? null;

            if (!$bookData) {
                return response()->json(['error' => 'Libro no encontrado en Open Library'], 404);
            }

            // Procesar autores (Buscar o Crear) dentro de una transacción
            $authorIds = [];
            $categoryIds = [];

            DB::transaction(function () use ($bookData, &$authorIds, &$categoryIds) {
                if (isset($bookData['authors'])) {
                    foreach ($bookData['authors'] as $apiAuthor) {
                        $author = Author::firstOrCreate(['name' => $apiAuthor['name']]);
                        $authorIds[] = $author->id;
                    }
                }

                // Procesar categorías (subjects) -> Tomamos las primeras 3
                if (isset($bookData['subjects'])) {
                    foreach (array_slice($bookData['subjects'], 0, 3) as $apiSubject) {
                        $category = Category::firstOrCreate(['name' => $apiSubject['name']]);
                        $categoryIds[] = $category->id;
                    }
                }
            });

            return response()->json([
                'title' => $bookData['title'] ?? '',
                'description' => is_array($bookData['description'] ?? null)
                    ? ($bookData['description']['value'] ?? '')
                    : ($bookData['description'] ?? ''),
                'published_at' => isset($bookData['publish_date'])
                    ? date('Y-m-d', strtotime($bookData['publish_date']))
                    : null,
                'cover_url' => $bookData['cover']['large'] ?? ($bookData['cover']['medium'] ?? null),
                'author_ids' => $authorIds,
                'category_ids' => $categoryIds,
            ]);
        } catch (\Exception $e) {
            Log::error('Error en búsqueda ISBN: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al buscar el libro'], 500);
        }
    }
}
