<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// refer: 04-Database Entity to Models.md, (fillable & CRUD dasar)
// refer: 05-Eloquent ORM & Relation.md, (belongsTo & belongsToMany relationships)
class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * refer: 04-Database Entity to Models.md, (fillable untuk mass assignment)
     */
    protected $fillable = [
        'author_id',
        'title',
        'year',
        'summary',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'year' => 'integer',
    ];

    /**
     * Get the author that wrote this book
     * refer: 05-Eloquent ORM & Relation.md, (belongsTo relationship)
     */
    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    /**
     * Get all films that are adaptations of this book
     * refer: 05-Eloquent ORM & Relation.md, (belongsToMany relationship)
     */
    public function films()
    {
        return $this->belongsToMany(Film::class);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('year', 'desc');
    }
}
