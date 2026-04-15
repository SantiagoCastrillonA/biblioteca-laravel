<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Book extends Model
{
    protected $fillable = ['title', 'isbn', 'description', 'published_year', 'publis_at'];

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}