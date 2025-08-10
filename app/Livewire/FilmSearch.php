<?php

namespace App\Livewire;

use App\Models\Film;
use Livewire\Component;

class FilmSearch extends Component
{
    // Property yang bisa diakses dari view - simple seperti BookSearch
    public $cari = '';

    // Method yang dipanggil ketika property $cari berubah
    public function updatedCari()
    {
        // TODO: Tambahkan validasi atau logic tambahan ketika search berubah
        // Misalnya: logging, analytics, dll
    }

    public function render()
    {
        // Query sederhana: cari film berdasarkan title - sama pattern dengan BookSearch
        $films = Film::with('author')
            ->when($this->cari, function ($query) {
                return $query->where('title', 'like', '%' . $this->cari . '%');
            })
            ->orderBy('year', 'desc')
            ->get();

        return view('livewire.film-search', [
            'films' => $films
        ]);
    }
}
