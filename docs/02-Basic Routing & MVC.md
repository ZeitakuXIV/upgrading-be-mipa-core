# Backend Laravel - Basic Routing & MVC

## 1) Konsep Dasar MVC
Laravel menggunakan arsitektur **MVC (Model - View - Controller)**:
- **Model** → Mengelola data & logika bisnis (interaksi ke database) - contoh: `Author.php`, `Book.php`, `Film.php`
- **View** → Menampilkan data ke user (HTML, Blade template) - contoh: `books/index.blade.php`
- **Controller** → Menjembatani request user ke model dan view - contoh: `BookController.php`

## 2) Routing di Laravel
Routing menentukan URL apa yang memanggil fungsi tertentu.

📂 File: `routes/web.php`
```php
Route::get('/', function () {
    return view('welcome');
});

// Route untuk Authors, Books, Films
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
```
- **Route::get** → menangani request GET
- **->name()** → memberikan nama route untuk mudah referensi di view
- `[Controller::class, 'method']` → memanggil method tertentu di controller

---

## 3) Alur Kerja MVC dalam Aplikasi Kita
1. User akses `/books` → masuk ke `routes/web.php`
2. Route memanggil `BookController::index()`
3. Controller query data dari Model `Book`
4. Controller return view `books/index.blade.php` dengan data
5. View dirender ke browser dengan daftar buku

**Contoh Real dari Aplikasi:**
```php
// routes/web.php
Route::get('/books', [BookController::class, 'index'])->name('books.index');

// BookController.php
public function index() {
    $booksData = Book::select('id', 'title', 'year')->get();
    $books = $booksData->map(function ($book) {
        return [
            'id' => $book->id,
            'title' => $book->title,
            'year' => $book->year,
            'route' => route('books.show', $book->id)
        ];
    })->toArray();
    
    return view('books.index', compact('books'));
}
```

---

## 4) Hands-On Exercise - BookController sebagai Referensi
### 🎯 Tujuan
Memahami implementasi MVC melalui `BookController` yang sudah ada, kemudian mengaplikasikannya ke `FilmController`.

### 📚 **Step 1: Analisis BookController (Reference)**
Buka file `app/Http/Controllers/BookController.php` dan perhatikan pattern ini:

```php
// Method index() - Menampilkan semua books
public function index() {
    $booksData = Book::select('id', 'title', 'year')
        ->orderBy('year', 'desc')
        ->get();
    
    $books = $booksData->map(function ($book) {
        return [
            'id' => $book->id,
            'title' => $book->title,
            'year' => $book->year,
            'route' => route('books.show', $book->id)
        ];
    })->toArray();
    
    return view('books.index', compact('books'));
}

// Method show() - Menampilkan detail satu book
public function show($id) {
    $book = Book::find($id);
    
    if (!$book) {
        return redirect()->route('books.index')
            ->with('error', 'Book tidak ditemukan');
    }
    
    $book = [
        'id' => $book->id,
        'title' => $book->title,
        'year' => $book->year,
        'summary' => $book->summary,
        'route' => route('books.show', $book->id)
    ];
    
    return view('books.show', compact('book'));
}
```

**🔍 Pattern Analysis:**
1. **Query Model** → `Book::select()` atau `Book::find()`
2. **Transform Data** → Map ke array dengan keys yang konsisten
3. **Return View** → `view('template', compact('data'))`

---

### 🎬 **Step 2: Challenge - Implementasi FilmController**
Sekarang terapkan pattern yang sama ke `FilmController`:

**Target Routes (sudah ada di `routes/web.php`):**
```php
Route::get('/films', [FilmController::class, 'index'])->name('films.index');
Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');
```

**🎯 Challenge Tasks:**
1. **Implementasi `FilmController::index()`:**
   - Query semua film dengan `Film::select('id', 'title', 'year')`
   - Transform ke array format: `['id', 'title', 'year', 'route']`
   - Return ke view `films.index`

2. **Implementasi `FilmController::show($id)`:**
   - Find film by ID
   - Handle film not found (redirect dengan error)
   - Transform ke array format: `['id', 'title', 'year', 'synopsis', 'route']`
   - Return ke view `films.show`

**💡 Tips:**
- Copy pattern dari `BookController` sebagai template
- Ganti `Book` menjadi `Film`
- Ganti `books` menjadi `films`
- Gunakan field `synopsis` untuk film (bukan `summary` seperti book)

---

### 🧪 **Step 3: Testing**
1. **Jalankan server:**
   ```bash
   php artisan serve
   ```

2. **Test di browser:**
   - `http://127.0.0.1:8000/books` → Lihat reference implementation
   - `http://127.0.0.1:8000/films` → Test hasil implementasi Anda
   - Klik detail film → Test show method

3. **Debug jika error:**
   ```bash
   php artisan route:list --name=films
   ```

---

💡 **Debug Commands:**
- `php artisan route:list` → Melihat semua route yang tersedia
- `php artisan route:list --name=films` → Filter route yang mengandung 'films'
- Check terminal untuk error messages saat development

---

## 5) Advanced Pattern - Dynamic Routing dengan Model Binding
### 🎯 Tujuan
Memahami cara Laravel menghandle parameter URL secara otomatis dengan Route Model Binding.

### 📖 **Contoh: Book Detail dengan ID**
Lihat implementasi di route:
```php
// routes/web.php
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
```

Controller menangkap parameter `{id}`:
```php
// BookController.php
public function show($id) {
    $book = Book::find($id);
    
    if (!$book) {
        return redirect()->route('books.index')
            ->with('error', 'Book tidak ditemukan');
    }
    
    $book = [
        'id' => $book->id,
        'title' => $book->title,
        'year' => $book->year,
        'summary' => $book->summary,
        'route' => route('books.show', $book->id)
    ];
    
    return view('books.show', compact('book'));
}
```

### 🎬 **Challenge: Implementasi untuk Film**
Implementasikan pattern yang sama untuk film:

1. **Route sudah ada:**
   ```php
   Route::get('/films/{id}', [FilmController::class, 'show'])->name('films.show');
   ```

2. **Implementasi FilmController::show($id):**
   - Query film by ID: `Film::find($id)`
   - Handle not found case
   - Return view dengan data film

3. **Test URL:**
   - `http://127.0.0.1:8000/films/1` → Film dengan ID 1
   - `http://127.0.0.1:8000/films/999` → Handle film tidak ditemukan

---

## 6) Route Naming & Navigation
### 🎯 Best Practice untuk Named Routes

**Menggunakan named routes** memudahkan maintenance:
```php
// routes/web.php
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show');
```

**Dalam view**, gunakan `route()` helper:
```blade
<!-- books/index.blade.php -->
<a href="{{ route('books.show', $book['id']) }}">
    {{ $book['title'] }}
</a>

<!-- Navigation -->
<a href="{{ route('books.index') }}">📚 Books</a>
<a href="{{ route('films.index') }}">🎬 Films</a>
<a href="{{ route('authors.index') }}">👨‍💼 Authors</a>
```

**Dalam controller**, redirect dengan named route:
```php
return redirect()->route('books.index')
    ->with('success', 'Data berhasil disimpan');
```

### 💡 **Tips Navigation:**
- Gunakan `route('name')` instead of hardcoded URL
- Named routes otomatis update jika URL pattern berubah
- Lebih mudah untuk debugging dan maintenance

---

## 7) Summary & Next Steps
✅ **Apa yang sudah dipelajari:**
- Konsep MVC dalam Laravel
- Routing dengan named routes
- Controller pattern: Query → Transform → View
- Dynamic routing dengan parameter
- Navigation dengan route helper

🎯 **Challenge Summary:**
- BookController sebagai reference ✅
- FilmController implementation (challenge untuk student)
- AuthorController basic implementation sudah ada

📚 **Next Learning Path:**
1. **Database & Migration** → Memahami struktur database
2. **Models & Relationships** → Eloquent ORM dan relasi antar model
3. **Advanced Controller** → Validation, form handling, CRUD operations
4. **Livewire Components** → Reactive components untuk interaktivitas

**🚀 Keep Learning!**
