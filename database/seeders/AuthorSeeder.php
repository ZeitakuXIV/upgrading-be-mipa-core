<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seed minimal authors data for testing
     */
    public function run(): void
    {
        // refer: 05a-Eloquent Basic.md, (insert data dengan create())
        Author::create([
            'name' => 'J.K. Rowling',
            'bio' => 'British author, best known for the Harry Potter series.',
        ]);

        Author::create([
            'name' => 'Stephen King',
            'bio' => 'American author of horror, supernatural fiction, suspense, crime, science-fiction, and fantasy novels.',
        ]);

        // TODO: Isi data seed tambahan untuk variasi query (lebih banyak author) — opsional
        Author::create([
            'name' => 'Christopher Nolan',
            'bio' => 'British-American filmmaker known for his complex narratives and visual style.',
        ]);
    }
}
