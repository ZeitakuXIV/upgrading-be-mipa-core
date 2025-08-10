<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

// refer: 06-Creating First Controller.md, (struktur controller & tiga aksi sederhana)
// refer: 05a-Eloquent Basic.md, (select, orderBy, where)
class AuthorController extends Controller
{
    /**
     * Display a listing of authors with books count
     * refer: 05-Eloquent ORM & Relation.md, (withCount untuk menghitung relasi)
     * refer: 02-Basic Routing & MVC.md, (alur MVC: controller → view dengan compact)
     */
    public function index()
    {
        // refer: 05a-Eloquent Basic.md, (select & orderBy)
        $authorsData = Author::withCount('books')
            ->orderBy('name')
            ->get();

        // refer: 07-Data Structure & Debugging.md, (mapping ke array + kontrak data)
        $authors = $authorsData->map(function ($author) {
            return [
                'id' => $author->id,
                'name' => $author->name,
                'bio' => $author->bio,
                'books_count' => $author->books_count,
            ];
        })->toArray();

        // TODO: panggil dd($authors) saat dev untuk memastikan shape sesuai
        // dd($authors);

        // refer: 02-Basic Routing & MVC.md, (return view dengan compact untuk kirim data ke Blade)
        return view('authors.index', compact('authors'));
    }

    /**
     * Display the specified author with books
     * refer: 06-Creating First Controller.md, (show method dengan parameter)
     * refer: 05-Eloquent ORM & Relation.md, (eager loading dengan with())
     * refer: 02-Basic Routing & MVC.md, (controller return view dengan compact)
     */
    public function show($id)
    {
        // TODO: validasi id (jika tidak ada → kembalikan author=null untuk view)
        $authorData = Author::with(['books' => function ($query) {
            $query->select('id', 'author_id', 'title', 'year');
        }])->find($id);

        $author = null;
        if ($authorData) {
            // refer: 07-Data Structure & Debugging.md, (kontrak data terstruktur)
            $author = [
                'id' => $authorData->id,
                'name' => $authorData->name,
                'bio' => $authorData->bio,
                'books' => $authorData->books->map(function ($book) {
                    return [
                        'id' => $book->id,
                        'title' => $book->title,
                        'year' => $book->year,
                        'route' => route('books.show', $book->id),
                    ];
                })->toArray(),
            ];
        }

        // TODO: panggil dd($author) saat dev untuk memastikan shape sesuai
        // dd($author);

        // refer: 02-Basic Routing & MVC.md, (return view dengan compact untuk kirim data ke Blade)
        return view('authors.show', compact('author'));
    }
}
