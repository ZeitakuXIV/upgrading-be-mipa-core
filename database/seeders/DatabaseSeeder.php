<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Runs all seeders in correct order (authors → books → films)
     */
    public function run(): void
    {
        // Original user seeder (existing)
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // refer: 03-Database & Migration Basic.md, (seeder order penting untuk foreign keys)
        // Modul studi kasus seeders - urutan penting karena ada foreign key constraints
        $this->call([
            AuthorSeeder::class,  // First: authors (no dependencies)
            BookSeeder::class,    // Second: books (depends on authors)
            FilmSeeder::class,    // Third: films (depends on authors, creates pivot to books)
        ]);
    }
}
