<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::get('books/search-isbn', [BookController::class, 'searchByIsbn'])->name('books.search-isbn');
Route::resource('books', BookController::class);
Route::resource('authors', AuthorController::class);
Route::resource('categories', CategoryController::class);
