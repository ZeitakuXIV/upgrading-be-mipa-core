<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// refer: 04-Database Entity to Models.md, (fillable & CRUD dasar)
// refer: 05-Eloquent ORM & Relation.md, (hasMany relationships)
class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * refer: 04-Database Entity to Models.md, (fillable untuk mass assignment)
     */
    protected $fillable = [
        'name',
        'bio',
    ];

    /**
     * Get all books written by this author
     * refer: 05-Eloquent ORM & Relation.md, (hasMany relationship)
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }

    /**
     * Get all films created by this author
     * refer: 05-Eloquent ORM & Relation.md, (hasMany relationship)
     */
    public function films()
    {
        return $this->hasMany(Film::class);
    }

    // TODO: Tambahkan scope sederhana, misal scopeWithWorks($q) untuk author dengan karya (opsional)
    // TODO: Tambahkan casting sederhana jika diperlukan
}
