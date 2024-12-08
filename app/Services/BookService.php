<?php

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

    public function update($id, array $data)
    {
        return $this->bookRepository->updateBook($id, $data);
    }

    public function delete($request)
    {
        return $this->bookRepository->deleteBook($request->id);
    }
}
