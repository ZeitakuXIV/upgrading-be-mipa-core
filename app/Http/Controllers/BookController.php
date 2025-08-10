<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

// refer: 06-Creating First Controller.md, (struktur controller & tiga aksi sederhana)
// refer: 05a-Eloquent Basic.md, (select, orderBy, where)
class BookController extends Controller
{
    /**
     * Display a listing of books (BASIC - tanpa relasi dulu)
     *
     * Implementation lengkap untuk referensi FilmController challenge
     *
     * refer: 05a-Eloquent Basic.md, (select, orderBy)
     * refer: 07-Data Structure & Debugging.md, (mapping ke array kontrak data)
     * refer: 02-Basic Routing & MVC.md, (return view dengan compact)
     */
    public function index(Request $request)
    {
        // Step 1: Basic query tanpa relasi
        $booksData = Book::select('id', 'title', 'year')
            ->orderBy('year', 'desc')
            ->get();

        // Step 2: Map ke kontrak data array
        // refer: 07-Data Structure & Debugging.md, (bentuk array siap view)
        $books = $booksData->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'year' => $book->year,
                'route' => route('books.show', $book->id)
            ];
        })->toArray();

        // TODO: gunakan dd($books) untuk cek data structure saat development
        // dd($books);

        // refer: 02-Basic Routing & MVC.md, (return view dengan compact)
        return view('books.index', compact('books'));
    }

    /**
     * Display the specified book (BASIC - tanpa relasi dulu)
     *
     * Implementation lengkap untuk referensi FilmController challenge
     *
     * refer: 05a-Eloquent Basic.md, (find method)
     * refer: 07-Data Structure & Debugging.md, (kontrak data basic)
     */
    public function show($id)
    {
        // Step 1: Find book by id
        $bookData = Book::find($id);

        // Step 2: Handle null case
        $book = null;
        if ($bookData) {
            // Step 3: Map ke kontrak data
            $book = [
                'id' => $bookData->id,
                'title' => $bookData->title,
                'year' => $bookData->year,
                'summary' => $bookData->summary
            ];
        }

        // TODO: gunakan dd($book) untuk cek data structure saat development
        // dd($book);

        // refer: 02-Basic Routing & MVC.md, (return view dengan compact)
        return view('books.show', compact('book'));
    }

    /**
     * Get latest book by year
     *
     * Implementation lengkap untuk referensi FilmController challenge
     *
     * refer: 05a-Eloquent Basic.md, (orderBy & first)
     */
    public function latest()
    {
        // Step 1: Query book dengan year tertinggi
        $bookData = Book::orderBy('year', 'desc')->first();

        // Step 2: Map ke kontrak data (sama dengan show)
        $book = null;
        if ($bookData) {
            $book = [
                'id' => $bookData->id,
                'title' => $bookData->title,
                'year' => $bookData->year,
                'summary' => $bookData->summary
            ];
        }

        // refer: 02-Basic Routing & MVC.md, (return view dengan compact)
        return view('books.latest', compact('book'));
    }

    // ===== ADVANCED METHODS (Untuk referensi advanced challenges) =====

    /**
     * ADVANCED: Index with filter
     *
     * Referensi untuk FilmController advanced challenge
     *
     * refer: 05a-Eloquent Basic.md, (conditional query dengan when())
     */
    public function indexWithFilter(Request $request)
    {
        // Base query sama dengan index basic
        $booksData = Book::select('id', 'title', 'year')
            ->orderBy('year', 'desc');

        // Add conditional filter
        // refer: 05a-Eloquent Basic.md, (when() untuk conditional query)
        $booksData = $booksData->when($request->q, function($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        });

        $booksData = $booksData->get();

        // Same mapping as basic index
        $books = $booksData->map(function ($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'year' => $book->year,
                'route' => route('books.show', $book->id)
            ];
        })->toArray();

        return view('books.index', compact('books'));
    }

    /**
     * ADVANCED: Show with author info
     *
     * Referensi untuk FilmController dengan relasi
     *
     * refer: 05-Eloquent ORM & Relation.md, (eager loading dengan with())
     */
    public function showWithAuthor($id)
    {
        // Query dengan eager loading author
        $bookData = Book::with('author')->find($id);

        $book = null;
        if ($bookData) {
            // Kontrak data dengan nested author
            $book = [
                'id' => $bookData->id,
                'title' => $bookData->title,
                'year' => $bookData->year,
                'summary' => $bookData->summary,
                'author' => [
                    'id' => $bookData->author->id,
                    'name' => $bookData->author->name
                ]
            ];
        }

        return view('books.show-with-author', compact('book'));
    }

    /**
     * EXPERT: Show with all relationships
     *
     * Referensi untuk FilmController full relations
     *
     * refer: 05-Eloquent ORM & Relation.md, (multiple eager loading)
     */
    public function showWithRelations($id)
    {
        // Query dengan multiple eager loading
        $bookData = Book::with(['author', 'films.author'])
            ->find($id);

        $book = null;
        if ($bookData) {
            // Kontrak data lengkap dengan nested relationships
            $book = [
                'id' => $bookData->id,
                'title' => $bookData->title,
                'year' => $bookData->year,
                'summary' => $bookData->summary,
                'author' => [
                    'id' => $bookData->author->id,
                    'name' => $bookData->author->name
                ],
                'films' => $bookData->films->sortBy('year')->map(function ($film) {
                    return [
                        'id' => $film->id,
                        'title' => $film->title,
                        'year' => $film->year,
                        'author_name' => $film->author->name,
                        'route' => route('films.show', $film->id)
                    ];
                })->values()->toArray()
            ];
        }

        return view('books.show-full', compact('book'));
    }
}
