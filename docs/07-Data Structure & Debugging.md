## 📚 Contoh: Books (List & Detail)

### 1) Books List — `BookController@index`
**Controller**
```php
use App\Models\Book;

public function index()
{
    $books = Book::query()
        ->select(['id','title','author','year','created_at'])
        ->orderByDesc('created_at')
        ->get();

    $items = $books->map(fn($b) => [
        'id'     => $b->id,
        'title'  => $b->title,
        'author' => $b->author,
        'year'   => (int) $b->year,
        'route'  => route('books.show', $b->id),
        'added'  => optional($b->created_at)->format('d M Y'),
    ])->toArray();

    $payload = compact('items');
    dd($payload); // ✅ cek shape sebelum render

    // return view('books.index', $payload);
}
```

**Output `dd()` (yang diharapkan)**
*data sudah sesuai kebutuhan*
```php
array:1 [
  "items" => array:3 [
    0 => array:6 [
      "id" => 7
      "title" => "Clean Code"
      "author" => "Robert C. Martin"
      "year" => 2008
      "route" => "http://127.0.0.1:8000/books/7"
      "added" => "02 Mar 2025"
    ]
    1 => array:6 [ … ]
    2 => array:6 [ … ]
  ]
]
```

**Blade hint — `resources/views/books/index.blade.php`**
```blade
<h1>Daftar Buku</h1>
<ul>
  @foreach($items as $b)
    <li>
      <a href="{{ $b['route'] }}">{{ $b['title'] }}</a>
      <small>{{ $b['author'] }} ({{ $b['year'] }}) • {{ $b['added'] }}</small>
    </li>
  @endforeach
</ul>
```

**Kontrak Data (List)**
```
Halaman: Books List
Variabel: 
- items[]: { id:int, title:string, author:string, year:int, route:string, added:string('d M Y') }
Catatan:
- FE pakai 'route' untuk link detail
- 'added' sudah diformat; tidak ada Carbon di Blade
```

---

### 2) Book Detail — `BookController@show`
**Controller**
```php
use App\Models\Book;

public function show($id)
{
    $b = Book::query()
        ->select(['id','title','author','year','summary','created_at'])
        ->find($id);

    $book = $b ? [
        'id'      => $b->id,
        'title'   => $b->title,
        'author'  => $b->author,
        'year'    => (int) $b->year,
        'summary' => (string) $b->summary,
        'added'   => optional($b->created_at)->format('d M Y'),
    ] : null;

    $payload = compact('book');
    dd($payload); // ✅ cek sebelum render

    // return view('books.show', $payload);
}
```

**Output `dd()` (yang diharapkan)**
```php
array:1 [
  "book" => array:6 [
    "id" => 7
    "title" => "Clean Code"
    "author" => "Robert C. Martin"
    "year" => 2008
    "summary" => "Praktik menulis kode yang bersih."
    "added" => "02 Mar 2025"
  ]
]
```

**Blade hint — `resources/views/books/show.blade.php`**
```blade
<h1>Detail Buku</h1>

@isset($book)
  <p>Judul: {{ $book['title'] }}</p>
  <p>Penulis: {{ $book['author'] }}</p>
  <p>Tahun: {{ $book['year'] }}</p>
  <p>Ringkasan: {{ $book['summary'] }}</p>
  <p>Ditambah: {{ $book['added'] }}</p>
@else
  <p style="color:red">Buku tidak ditemukan.</p>
@endisset

<p><a href="{{ route('books.index') }}">← Kembali</a></p>
```

**Kontrak Data (Detail)**
```
Halaman: Book Detail
Variabel:
- book: { id:int, title:string, author:string, year:int, summary:string, added:string('d M Y') } | null
Catatan:
- FE handle state "tidak ditemukan" saat book = null
```

---

### 3) Checklist mini (Books)
- [ ] `dd()` hanya menunjukkan array asosiatif (tanpa model mentah).
- [ ] Key konsisten dengan yang dipakai Blade.
- [ ] `route` sudah string URL dari backend.
- [ ] Tanggal (`added`) diformat di backend.
