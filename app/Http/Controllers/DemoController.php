<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// refer: 06-Creating First Controller.md, (struktur controller & tiga aksi sederhana)
// refer: 07-Data Structure & Debugging.md, (kontrak data: bentuk array siap Blade/FE)
// DEMO CONTROLLER - Mock data untuk testing tanpa database
class DemoController extends Controller
{
    /**
     * Demo Authors List
     * refer: 05-Eloquent ORM & Relation.md, (withCount untuk menghitung relasi)
     * refer: 07-Data Structure & Debugging.md, (kontrak data: bentuk array siap Blade/FE)
     */
    public function authors()
    {
        // Mock data sesuai kontrak data
        $payload = [
            'items' => [
                [
                    'id' => 1,
                    'name' => 'J.K. Rowling',
                    'books_count' => 2,
                    'route' => route('demo.author', 1),
                ],
                [
                    'id' => 2,
                    'name' => 'Stephen King',
                    'books_count' => 3,
                    'route' => route('demo.author', 2),
                ],
                [
                    'id' => 3,
                    'name' => 'Christopher Nolan',
                    'books_count' => 0,
                    'route' => route('demo.author', 3),
                ],
            ]
        ];

        // TODO: panggil dd($payload) saat dev untuk memastikan shape sesuai
        // dd($payload);

        return response()->json($payload);
    }

    /**
     * Demo Author Detail
     * refer: 06-Creating First Controller.md, (show method dengan parameter)
     */
    public function author($id)
    {
        // Mock data berdasarkan ID
        $authors = [
            1 => [
                'id' => 1,
                'name' => 'J.K. Rowling',
                'bio' => 'British author, best known for the Harry Potter series.',
                'books' => [
                    [
                        'id' => 1,
                        'title' => 'Harry Potter and the Philosopher\'s Stone',
                        'year' => 1997,
                        'route' => route('demo.book', 1),
                    ],
                    [
                        'id' => 2,
                        'title' => 'Harry Potter and the Chamber of Secrets',
                        'year' => 1998,
                        'route' => route('demo.book', 2),
                    ],
                ],
            ],
            2 => [
                'id' => 2,
                'name' => 'Stephen King',
                'bio' => 'American author of horror, supernatural fiction, suspense, crime, science-fiction, and fantasy novels.',
                'books' => [
                    [
                        'id' => 3,
                        'title' => 'The Shining',
                        'year' => 1977,
                        'route' => route('demo.book', 3),
                    ],
                    [
                        'id' => 4,
                        'title' => 'It',
                        'year' => 1986,
                        'route' => route('demo.book', 4),
                    ],
                    [
                        'id' => 5,
                        'title' => 'Carrie',
                        'year' => 1974,
                        'route' => route('demo.book', 5),
                    ],
                ],
            ],
            3 => [
                'id' => 3,
                'name' => 'Christopher Nolan',
                'bio' => 'British-American filmmaker known for his complex narratives and visual style.',
                'books' => [],
            ],
        ];

        // TODO: validasi id (jika tidak ada → kembalikan payload author=null)
        if (!isset($authors[$id])) {
            return response()->json(['author' => null], 404);
        }

        $payload = ['author' => $authors[$id]];

        // TODO: panggil dd($payload) saat dev untuk memastikan shape sesuai
        // dd($payload);

        return response()->json($payload);
    }

    /**
     * Demo Books List
     * refer: 05a-Eloquent Basic.md, (orderBy untuk sorting)
     */
    public function books()
    {
        $payload = [
            'items' => [
                [
                    'id' => 1,
                    'title' => 'Harry Potter and the Philosopher\'s Stone',
                    'author' => 'J.K. Rowling',
                    'year' => 1997,
                    'route' => route('demo.book', 1),
                    'added' => '10 Aug 2025',
                ],
                [
                    'id' => 2,
                    'title' => 'Harry Potter and the Chamber of Secrets',
                    'author' => 'J.K. Rowling',
                    'year' => 1998,
                    'route' => route('demo.book', 2),
                    'added' => '10 Aug 2025',
                ],
                [
                    'id' => 4,
                    'title' => 'It',
                    'author' => 'Stephen King',
                    'year' => 1986,
                    'route' => route('demo.book', 4),
                    'added' => '10 Aug 2025',
                ],
                [
                    'id' => 3,
                    'title' => 'The Shining',
                    'author' => 'Stephen King',
                    'year' => 1977,
                    'route' => route('demo.book', 3),
                    'added' => '10 Aug 2025',
                ],
                [
                    'id' => 5,
                    'title' => 'Carrie',
                    'author' => 'Stephen King',
                    'year' => 1974,
                    'route' => route('demo.book', 5),
                    'added' => '10 Aug 2025',
                ],
            ]
        ];

        return response()->json($payload);
    }

    /**
     * Demo Book Detail
     * refer: 05-Eloquent ORM & Relation.md, (eager loading multiple relations)
     */
    public function book($id)
    {
        $books = [
            1 => [
                'id' => 1,
                'title' => 'Harry Potter and the Philosopher\'s Stone',
                'author' => ['id' => 1, 'name' => 'J.K. Rowling'],
                'year' => 1997,
                'summary' => 'The first book in the Harry Potter series.',
                'films' => [
                    ['id' => 1, 'title' => 'Harry Potter and the Philosopher\'s Stone (Film)', 'year' => 2001],
                ],
                'added' => '10 Aug 2025',
            ],
            3 => [
                'id' => 3,
                'title' => 'The Shining',
                'author' => ['id' => 2, 'name' => 'Stephen King'],
                'year' => 1977,
                'summary' => 'A horror novel about a haunted hotel.',
                'films' => [
                    ['id' => 2, 'title' => 'The Shining (Film)', 'year' => 1980],
                ],
                'added' => '10 Aug 2025',
            ],
            4 => [
                'id' => 4,
                'title' => 'It',
                'author' => ['id' => 2, 'name' => 'Stephen King'],
                'year' => 1986,
                'summary' => 'A horror novel about a shape-shifting entity.',
                'films' => [
                    ['id' => 3, 'title' => 'It (Film)', 'year' => 2017],
                ],
                'added' => '10 Aug 2025',
            ],
        ];

        if (!isset($books[$id])) {
            return response()->json(['book' => null], 404);
        }

        return response()->json($books[$id]);
    }

    /**
     * Demo Films List
     * refer: 05-Eloquent ORM & Relation.md, (withCount untuk menghitung relasi many-to-many)
     */
    public function films()
    {
        $payload = [
            'items' => [
                [
                    'id' => 4,
                    'title' => 'Inception',
                    'year' => 2010,
                    'adapted_from_books' => 0,
                    'route' => route('demo.film', 4),
                ],
                [
                    'id' => 3,
                    'title' => 'It (Film)',
                    'year' => 2017,
                    'adapted_from_books' => 1,
                    'route' => route('demo.film', 3),
                ],
                [
                    'id' => 1,
                    'title' => 'Harry Potter and the Philosopher\'s Stone (Film)',
                    'year' => 2001,
                    'adapted_from_books' => 1,
                    'route' => route('demo.film', 1),
                ],
                [
                    'id' => 2,
                    'title' => 'The Shining (Film)',
                    'year' => 1980,
                    'adapted_from_books' => 1,
                    'route' => route('demo.film', 2),
                ],
            ]
        ];

        return response()->json($payload);
    }

    /**
     * Demo Film Detail
     * refer: 05-Eloquent ORM & Relation.md, (eager loading nested relations)
     */
    public function film($id)
    {
        $films = [
            1 => [
                'id' => 1,
                'title' => 'Harry Potter and the Philosopher\'s Stone (Film)',
                'author' => ['id' => 1, 'name' => 'J.K. Rowling'],
                'year' => 2001,
                'synopsis' => 'Film adaptation of the first Harry Potter book.',
                'books' => [
                    ['id' => 1, 'title' => 'Harry Potter and the Philosopher\'s Stone', 'year' => 1997, 'author' => 'J.K. Rowling'],
                ],
            ],
            4 => [
                'id' => 4,
                'title' => 'Inception',
                'author' => ['id' => 3, 'name' => 'Christopher Nolan'],
                'year' => 2010,
                'synopsis' => 'Original screenplay by Christopher Nolan about dreams within dreams.',
                'books' => [], // No source books (original screenplay)
            ],
        ];

        if (!isset($films[$id])) {
            return response()->json(['film' => null], 404);
        }

        return response()->json($films[$id]);
    }

    /**
     * Demo Latest Film
     * refer: 05a-Eloquent Basic.md, (orderBy & first/take untuk single record)
     */
    public function latestFilm()
    {
        $payload = [
            'id' => 3,
            'title' => 'It (Film)',
            'author' => ['id' => 3, 'name' => 'Christopher Nolan'],
            'year' => 2017,
            'synopsis' => 'Modern adaptation of Stephen King\'s It novel.',
        ];

        return response()->json($payload);
    }
}
