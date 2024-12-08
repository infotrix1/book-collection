<?php

namespace App\Repositories;

use App\Models\Book;

class BookRepository
{
    public function getAllBooks($filters)
    {
        $query = Book::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['year'])) {
            $query->where('published_year', $filters['year']);
        }

        return $query->paginate(10);
    }

    public function createBook(array $data)
    {
        return Book::create($data);
    }

    public function updateBook($id, array $data)
    {
        $book = Book::where('id',$id)->update($data);
        return $book;
    }

    public function deleteBook($id)
    {
        $book = Book::find($id);
        $book->delete();
    }
}
