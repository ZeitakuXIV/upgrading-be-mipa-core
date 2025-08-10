<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
// refer: 05-Eloquent ORM & Relation.md, (belongsToMany pivot table)
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates pivot table for book-film many-to-many relationship (film adaptations)
     */
    public function up(): void
    {
        Schema::create('book_film', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
            $table->foreignId('film_id')->constrained('films')->onDelete('cascade');
            $table->timestamps();

            // Ensure unique book-film pairs
            $table->unique(['book_id', 'film_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_film');
    }
};
