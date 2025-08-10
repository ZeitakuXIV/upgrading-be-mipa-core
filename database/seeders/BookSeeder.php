<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed books data dengan relasi ke authors
     */
    public function run(): void
    {
        // refer: 05a-Eloquent Basic.md, (insert data dengan create() & foreign key)

        // Books by J.K. Rowling (author_id: 1)
        Book::create([
            'author_id' => 1,
            'title' => 'Harry Potter and the Philosopher\'s Stone',
            'year' => 1997,
            'summary' => 'The first book in the Harry Potter series.',
        ]);

        Book::create([
            'author_id' => 1,
            'title' => 'Harry Potter and the Chamber of Secrets',
            'year' => 1998,
            'summary' => 'The second book in the Harry Potter series.',
        ]);

        // Books by Stephen King (author_id: 2)
        Book::create([
            'author_id' => 2,
            'title' => 'The Shining',
            'year' => 1977,
            'summary' => 'A horror novel about a haunted hotel.',
        ]);

        // TODO: Isi data seed tambahan untuk variasi query (>=5 book) — opsional
        Book::create([
            'author_id' => 2,
            'title' => 'It',
            'year' => 1986,
            'summary' => 'A horror novel about a shape-shifting entity.',
        ]);

        Book::create([
            'author_id' => 2,
            'title' => 'Carrie',
            'year' => 1974,
            'summary' => 'Stephen King\'s first published novel about telekinetic powers.',
        ]);
    }
}
