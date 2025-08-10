<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookSearch extends Component
{
    // Property yang bisa diakses dari view
    public $cari = '';

    // Method yang dipanggil ketika property $cari berubah
    public function updatedCari()
    {
        // TODO: Tambahkan validasi atau logic tambahan ketika search berubah
        // Misalnya: logging, analytics, dll
    }

    public function render()
    {
        // Query sederhana: cari buku berdasarkan title
        $books = Book::with('author')
            ->when($this->cari, function ($query) {
                return $query->where('title', 'like', '%' . $this->cari . '%');
            })
            ->orderBy('year', 'desc')
            ->get();

        return view('livewire.book-search', [
            'books' => $books
        ]);
    }
}
