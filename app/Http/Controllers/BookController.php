<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Inertia\Inertia;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index()
    {
        return Inertia::render('Books/Index');
    }

    public function list(Request $request)
    {
        $filters = $request->only(['status', 'year']);
        $books = $this->bookService->getBooksWithFilters($filters);

        return response()->json([
            'books' => $books,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'required|integer',
            'status' => 'required|in:available,borrowed,reserved',
        ]);

        $this->bookService->create($request->all());

        return redirect()->route('books.index');
    }

    public function edit(Book $book)
    {
        return Inertia::render('Books/Edit', [
            'book' => $book,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_year' => 'required|integer',
            'status' => 'required|in:available,borrowed,reserved',
        ]);

        $id = $request->get('id');

        $data = [
            'title' => $request->get('title'),
            'author' => $request->get('author'),
            'description' => $request->get('description'),
            'published_year' => $request->get('published_year'),
            'status' => $request->get('status')
        ];

        $this->bookService->update($id, $data);

        return redirect()->route('books.index');
    }

    public function destroy(Request $request)
    {
        $this->bookService->delete($request);

        return redirect()->route('books.index');
    }
}
