<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
// refer: 05-Eloquent ORM & Relation.md, (foreign key relationships)
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates books table with author relationship
     */
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained('authors')->onDelete('cascade');
            $table->string('title');
            $table->integer('year');
            $table->text('summary')->nullable(); // refer: 04-Database Entity to Models.md, (nullable fields)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
