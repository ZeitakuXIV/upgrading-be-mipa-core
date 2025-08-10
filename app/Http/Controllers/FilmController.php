<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

// refer: 06-Creating First Controller.md, (struktur controller & tiga aksi sederhana)
// refer: 05a-Eloquent Basic.md, (select, orderBy, where)
class FilmController extends Controller
{
    /**
     * CHALLENGE LEVEL 1: Display a listing of films (BASIC - tanpa relasi dulu)
     *
     * Requirements:
     * 1. Load semua films (id, title, year, synopsis)
     * 2. Order by year descending (terbaru dulu)
     * 3. Map ke array kontrak data sederhana
     *
     * refer: 05a-Eloquent Basic.md, (select, orderBy)
     * refer: 07-Data Structure & Debugging.md, (mapping ke array kontrak data)
     * refer: 02-Basic Routing & MVC.md, (return view dengan compact)
     */
    public function index(Request $request)
    {
        // TODO: Query films dengan select dan orderBy
        // Hint: Film::select('id', 'title', 'year')->orderBy('year', 'desc')->get()

        // TODO: Map ke kontrak data array:
        // ['id' => $film->id, 'title' => $film->title, 'year' => $film->year]

        // TODO: Return view dengan compact('films')

        // Skeleton code (hapus ini setelah implementasi):
        $films = [];

        return view('films.index', compact('films'));
    }

    /**
     * CHALLENGE LEVEL 2: Display the specified film (BASIC - tanpa relasi dulu)
     *
     * Requirements:
     * 1. Find film by id
     * 2. Handle jika film tidak ditemukan (return film=null)
     * 3. Map ke kontrak data: {id, title, year, synopsis}
     *
     * refer: 05a-Eloquent Basic.md, (find method)
     * refer: 07-Data Structure & Debugging.md, (kontrak data basic)
     */
    public function show($id)
    {
        // TODO: Find film by id
        // Hint: Film::find($id)

        // TODO: Handle null case (film tidak ditemukan)
        // TODO: Map ke kontrak data jika film ada
        // TODO: Return view dengan compact('film')

        // Skeleton code (hapus ini setelah implementasi):
        $film = null;

        return view('films.show', compact('film'));
    }

    /**
     * CHALLENGE LEVEL 3: Get latest film by year (BASIC)
     *
     * Requirements:
     * 1. Find 1 film dengan year paling tinggi (terbaru)
     * 2. Handle jika tidak ada film (return film=null)
     * 3. Map ke kontrak data yang sama dengan show()
     *
     * refer: 05a-Eloquent Basic.md, (orderBy & first)
     */
    public function latest()
    {
        // TODO: Query film dengan year tertinggi
        // Hint: Film::orderBy('year', 'desc')->first()

        // TODO: Map ke kontrak data
        // TODO: Return view dengan compact('film')

        // Skeleton code (hapus ini setelah implementasi):
        $film = null;

        return view('films.latest', compact('film'));
    }

    // ===== ADVANCED CHALLENGES (Untuk yang sudah selesai basic) =====

    /**
     * ADVANCED CHALLENGE: Add year filter to index
     *
     * Tambahkan ke method index() setelah basic selesai:
     * - Support query parameter ?year=2001
     * - Gunakan when() untuk conditional query
     *
     * refer: 05a-Eloquent Basic.md, (conditional query dengan when())
     */
    public function indexWithFilter(Request $request)
    {
        // TODO: Copy logic dari index() basic
        // TODO: Tambahkan ->when($request->year, function($query, $year) {...})
        // TODO: Test dengan ?year=2001

        // Ini method terpisah untuk advanced learners
        $films = [];
        return view('films.index', compact('films'));
    }

    /**
     * ADVANCED CHALLENGE: Show film with author info
     *
     * Method baru untuk film dengan relasi author (tanpa books dulu)
     *
     * refer: 05-Eloquent ORM & Relation.md, (eager loading dengan with())
     */
    public function showWithAuthor($id)
    {
        // TODO: Film::with('author')->find($id)
        // TODO: Map ke kontrak data dengan nested author: {id, name}
        // TODO: Handle null case

        $film = null;
        return view('films.show-with-author', compact('film'));
    }

    /**
     * EXPERT CHALLENGE: Show film with all relationships
     *
     * Method baru untuk film dengan semua relasi (author + books)
     * Buat setelah showWithAuthor() selesai
     *
     * refer: 05-Eloquent ORM & Relation.md, (multiple eager loading)
     */
    public function showWithRelations($id)
    {
        // TODO: Film::with(['author', 'books.author'])->find($id)
        // TODO: Map ke kontrak data lengkap dengan nested relationships
        // TODO: Sort books by year ascending

        $film = null;
        return view('films.show-full', compact('film'));
    }
}
