<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// refer: 03-Database & Migration Basic.md, (migrate, rollback, seeder)
return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates authors table with basic fields for author information
     */
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('bio')->nullable(); // refer: 04-Database Entity to Models.md, (nullable fields)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
