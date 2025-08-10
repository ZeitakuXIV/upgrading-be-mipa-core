<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed films data dengan relasi ke authors dan pivot ke books
     */
    public function run(): void
    {
        // refer: 05a-Eloquent Basic.md, (insert data dengan create() & foreign key)

        // Films adaptasi dari books (beberapa oleh author yang sama, beberapa berbeda)
        $harryPotterFilm = Film::create([
            'author_id' => 1, // J.K. Rowling juga "author" film (produser/konsultan)
            'title' => 'Harry Potter and the Philosopher\'s Stone (Film)',
            'year' => 2001,
            'synopsis' => 'Film adaptation of the first Harry Potter book.',
        ]);

        $shiningFilm = Film::create([
            'author_id' => 3, // Christopher Nolan sebagai "author" film (director)
            'title' => 'The Shining (Film)',
            'year' => 1980,
            'synopsis' => 'Stanley Kubrick\'s adaptation of Stephen King\'s novel.',
        ]);

        $itFilm = Film::create([
            'author_id' => 3, // Christopher Nolan
            'title' => 'It (Film)',
            'year' => 2017,
            'synopsis' => 'Modern adaptation of Stephen King\'s It novel.',
        ]);

        // TODO: Isi data seed tambahan untuk variasi query (>=4 film) — opsional
        $originalFilm = Film::create([
            'author_id' => 3, // Christopher Nolan
            'title' => 'Inception',
            'year' => 2010,
            'synopsis' => 'Original screenplay by Christopher Nolan about dreams within dreams.',
        ]);

        // TODO: Pivot beberapa relasi (film adaptasi buku) di seeder
        // refer: 05-Eloquent ORM & Relation.md, (belongsToMany attach untuk pivot)

        // Attach films to their source books
        $harryPotterFilm->books()->attach([1]); // Harry Potter book id: 1
        $shiningFilm->books()->attach([3]); // The Shining book id: 3
        $itFilm->books()->attach([4]); // It book id: 4
        // Inception tidak ada source book (original screenplay)
    }
}
