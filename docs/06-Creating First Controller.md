#backend
# 🎯 Challenge — 06 Creating First Controller (Film)

> Target: bikin 1 controller sederhana dengan 3 route (index, show, latest) menggunakan data array di controller, lalu upgrade ke array asosiatif (judul + tahun).  

---

## 1) routes/web.php
```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;

// TODO: tambahkan route daftar film -> FilmController@index
Route::get('/films', [FilmController::class, 'index']);

// TODO: tambahkan route detail film -> FilmController@show (param {id})
Route::get('/films/{id}', [FilmController::class, 'show']);

// TODO: tambahkan route film terbaru -> FilmController@latest
Route::get('/films-latest', [FilmController::class, 'latest']);
```

---

## 2) app/Http/Controllers/FilmController.php
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FilmController extends Controller
{
    // TODO: ganti array sederhana ini menjadi array asosiatif:
    // dari: ['Inception', 'The Matrix', 'Interstellar']
    // ke: [ ['title'=>'Inception','year'=>2010], ... ]
    private array $films = [
        // TODO: isi minimal 3 film: title + year
        ['title' => 'Inception', 'year' => 2010],
        ['title' => 'The Matrix', 'year' => 1999],
        ['title' => 'Interstellar', 'year' => 2014],
    ];

    public function index()
    {
        // TODO: kirim $this->films ke view 'films.index'
        return view('films.index', ['films' => $this->films]); // TODO: cek
    }

    public function show($id)
    {
        // TODO: validasi index $id (jika tidak ada, tampilkan "Film tidak ditemukan")
        $film = $this->films[$id] ?? null;
        if (!$film) {
            // TODO: kirim pesan error ke view 'films.show'
            return view('films.show', ['film' => null, 'error' => 'Film tidak ditemukan']);
        }

        // TODO: kirim 1 item film (title + year) ke view 'films.show'
        return view('films.show', ['film' => $film]);
    }

    public function latest()
    {
        // TODO: ambil film terbaru berdasarkan 'year'
        // hint: gunakan usort/collection untuk cari max year
        $latest = collect($this->films)->sortByDesc('year')->first();

        // TODO: kirim $latest ke view 'films.latest'
        return view('films.latest', ['film' => $latest]);
    }
}
```

---

## 3) resources/views/films/index.blade.php
```blade
{{-- TODO: tampilkan daftar film (title + year) --}}
{{-- hint: loop @foreach, link ke /films/{index} --}}

<h1>Daftar Film</h1>

<ul>
  @foreach($films as $i => $film)
    <li>
      <a href="{{ url('/films/'.$i) }}">
        {{ $film['title'] }} ({{ $film['year'] }})
      </a>
    </li>
  @endforeach
</ul>

<p>
  {{-- TODO: tambahkan link ke film terbaru --}}
  <a href="{{ url('/films-latest') }}">Lihat Film Terbaru</a>
</p>
```

---

## 4) resources/views/films/show.blade.php
```blade
{{-- TODO: tampilkan detail 1 film (title + year), handle error jika film tidak ada --}}

<h1>Detail Film</h1>

@isset($error)
  <p style="color:red">{{ $error }}</p>
@else
  <p>Judul: {{ $film['title'] }}</p>
  <p>Tahun: {{ $film['year'] }}</p>
@endisset

<p><a href="{{ url('/films') }}">← Kembali ke daftar</a></p>
```

---

## 5) resources/views/films/latest.blade.php
```blade
{{-- TODO: tampilkan film terbaru (title + year) --}}

<h1>Film Terbaru</h1>

<p>Judul: {{ $film['title'] }}</p>
<p>Tahun: {{ $film['year'] }}</p>

<p><a href="{{ url('/films') }}">← Kembali ke daftar</a></p>
```

---

## ✅ Checklist
- [ ] `/films` menampilkan list (judul + tahun)  
- [ ] `/films/{id}` menampilkan detail atau pesan error jika id tidak valid  
- [ ] `/films-latest` menampilkan 1 film dengan tahun paling baru  
- [ ] Data di controller sudah **array asosiatif** (bukan array string biasa)

