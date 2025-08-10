#backend
# ⚡ Livewire — Reactive Search (Books)

## 1) Instalasi (sekali saja di project)
```bash
composer require livewire/livewire
```

Di layout Blade utama (jika perlu), pastikan ada directive Livewire:
```blade
{{-- resources/views/layouts/app.blade.php --}}
<html>
  <head>
    @livewireStyles
  </head>
  <body>
    @yield('content')
    @livewireScripts
  </body>
</html>
```

---

## 2) Buat Komponen
```bash
php artisan make:livewire BooksSearch
```

**Class**
```php
// app/Livewire/BooksSearch.php
namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BooksSearch extends Component
{
    public string $q = ''; // query pencarian

    public function render()
    {
        // Query sederhana: cari di title atau author
        $books = Book::query()
            ->select(['id','title','author','year','created_at'])
            ->when($this->q, function ($q) {
                $term = '%'.$this->q.'%';
                $q->where(function ($w) use ($term) {
                    $w->where('title', 'like', $term)
                      ->orWhere('author', 'like', $term);
                });
            })
            ->orderByDesc('created_at')
            ->limit(20) // batasi hasil, biar ringan
            ->get()
            ->map(fn($b) => [
                'id'     => $b->id,
                'title'  => $b->title,
                'author' => $b->author,
                'year'   => (int) $b->year,
                'route'  => route('books.show', $b->id),
                'added'  => optional($b->created_at)->format('d M Y'),
            ])
            ->toArray();

        // // DEBUG (opsional saat upgrading)
        // dd(compact('books'));

        return view('livewire.books-search', compact('books'));
    }
}
```

**View**
```blade
{{-- resources/views/livewire/books-search.blade.php --}}
<div class="space-y-4">
  <div>
    <input
      type="text"
      placeholder="Cari judul/penulis…"
      class="input input-bordered w-full"
      wire:model.debounce.300ms="q"
    />
  </div>

  @if (empty($books))
    <p class="text-sm opacity-70">Tidak ada data.</p>
  @else
    <ul class="space-y-2">
      @foreach($books as $b)
        <li class="p-3 rounded border">
          <a href="{{ $b['route'] }}" class="font-semibold">
            {{ $b['title'] }}
          </a>
          <div class="text-sm opacity-80">
            {{ $b['author'] }} ({{ $b['year'] }}) • Ditambah: {{ $b['added'] }}
          </div>
        </li>
      @endforeach
    </ul>
  @endif
</div>
```

> Catatan: class input di atas pakai gaya DaisyUI (opsional). Kalau belum ada, ganti dengan class Tailwind biasa.

---

## 3) Tempatkan Komponen di Halaman

**Route + View kosong**
```php
// routes/web.php
Route::view('/books/live', 'books.live')->name('books.live');
```

```blade
{{-- resources/views/books/live.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="max-w-2xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Cari Buku</h1>
    @livewire('books-search')
  </div>
@endsection
```

---

## 4) Checklist Selesai
- [ ] Ketik di input → daftar buku berubah **tanpa reload**  
- [ ] Pencarian bekerja di **title** dan **author**  
- [ ] Link detail buku mengarah ke `books.show` (materi sebelumnya)  
- [ ] Query dibatasi (limit 20) agar ringan

---

## 5) Tantangan (opsional)
- Tambah filter **tahun** (dropdown) → `wire:model="year"` lalu `when($this->year, ...)`.
- Tambah indikator **loading**:
  ```blade
  <div wire:loading class="text-sm opacity-70">Memuat…</div>
  ```
- Debounce lebih agresif saat mengetik cepat: `.debounce.500ms`.

---

## 6) Debug Cepat
- Aktifkan `dd(compact('books'))` sementara di `render()` untuk cek shape data.  
- Pastikan semua field yang dipakai di Blade sudah ada di array (hindari passing model mentah).
