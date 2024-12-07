<?php

// app/Services/BookService.php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Models\Book;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function getBooksWithFilters($filters)
    {
        return $this->bookRepository->getAllBooks($filters);
    }

    public function create(array $data)
    {
        return $this->bookRepository->createBook($data);
    }

    public function update(Book $book, array $data)
    {
        return $this->bookRepository->updateBook($book, $data);
    }

    public function delete(Book $book)
    {
        return $this->bookRepository->deleteBook($book);
    }
}
