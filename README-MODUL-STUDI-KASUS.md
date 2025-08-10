# Modul Studi Kasus Backend Laravel (MVC dengan Views)

## 🎯 Tujuan

Modul backend Laravel yang menunjukkan alur lengkap **routing → migration → model → relasi → controller → view** dengan entitas: **Author**, **Book**, **Film**. Menggunakan pendekatan MVC tradisional dengan Views (bukan API JSON).

## 📚 Struktur Relasi

```
Author (1) -----> (Many) Book
Author (1) -----> (Many) Film
Book (Many) <---> (Many) Film (adaptasi)
```

## 🗂️ File-file yang Dibuat

### Database Layer
- `database/migrations/*_create_authors_table.php`
- `database/migrations/*_create_books_table.php`  
- `database/migrations/*_create_films_table.php`
- `database/migrations/*_create_book_film_table.php` (pivot)
- `database/seeders/AuthorSeeder.php`
- `database/seeders/BookSeeder.php`
- `database/seeders/FilmSeeder.php`
- Updated: `database/seeders/DatabaseSeeder.php`

### Model Layer  
- `app/Models/Author.php` - hasMany(Book, Film)
- `app/Models/Book.php` - belongsTo(Author), belongsToMany(Film)
- `app/Models/Film.php` - belongsTo(Author), belongsToMany(Book)

### Controller Layer (MVC dengan Views)
- `app/Http/Controllers/AuthorController.php` - index(), show() → return view dengan compact
- `app/Http/Controllers/BookController.php` - index(), show() → return view dengan compact
- `app/Http/Controllers/FilmController.php` - index(), show(), latest() → return view dengan compact
- `app/Http/Controllers/DemoController.php` - Demo dengan mock data (JSON response)

### View Layer (Blade Templates)
- `resources/views/authors/index.blade.php` - Authors list
- `resources/views/authors/show.blade.php` - Author detail
- `resources/views/books/index.blade.php` - Books list dengan search
- `resources/views/books/show.blade.php` - Book detail dengan films
- `resources/views/films/index.blade.php` - Films list dengan filter
- `resources/views/films/show.blade.php` - Film detail dengan books
- `resources/views/films/latest.blade.php` - Latest film

### Routing
- Updated: `routes/web.php` - Direct routes (tanpa prefix `/api`)

### Documentation
- `docs/10-Data-Contract.md` - Kontrak data lengkap

## 🛠️ Setup & Testing

### 1. Database Setup
```bash
php artisan migrate:fresh --seed
```

### 2. Start Server
```bash
php artisan serve
```

### 3. Test MVC Endpoints (Real Data with Views)

#### Authors
- **List**: http://localhost:8000/authors
- **Detail**: http://localhost:8000/authors/1

#### Books  
- **List**: http://localhost:8000/books
- **Detail**: http://localhost:8000/books/1
- **Search**: http://localhost:8000/books?q=harry

#### Films
- **List**: http://localhost:8000/films
- **Detail**: http://localhost:8000/films/1
- **Latest**: http://localhost:8000/films-latest
- **Filter**: http://localhost:8000/films?year=2001

### 4. Demo Endpoints (Mock Data - JSON Response)

Masih tersedia untuk referensi kontrak data:
- `GET /demo/authors` - JSON response with mock data
- `GET /demo/books` - JSON response with mock data  
- `GET /demo/films` - JSON response with mock data

## 🎮 Alur MVC yang Ditunjukkan

```
HTTP Request → Route → Controller → Model (+ Relations) → compact() → Blade View → HTML Response
```

### Contoh Alur:
1. **Request**: `GET /authors/1`
2. **Route**: `authors/{id}` → `AuthorController@show`
3. **Controller**: Query Author dengan books via Eloquent
4. **Data Processing**: Map ke array terstruktur  
5. **View**: `compact('author')` → `authors.show.blade.php`
6. **Response**: Rendered HTML dengan data author + books

## 📖 Rujukan Dokumen

Setiap file memiliki komentar yang merujuk ke dokumen materi:

- `// refer: 01-Installation.md` - Setup Laravel
- `// refer: 02-Basic Routing & MVC.md` - Routing, MVC flow, return view dengan compact
- `// refer: 03-Database & Migration Basic.md` - Migration, seeder, rollback
- `// refer: 04-Database Entity to Models.md` - Fillable, CRUD dasar
- `// refer: 05a-Eloquent Basic.md` - Query dasar, scopes
- `// refer: 05-Eloquent ORM & Relation.md` - Relations, eager loading
- `// refer: 06-Creating First Controller.md` - Controller structure
- `// refer: 07-Data Structure & Debugging.md` - Data processing, dd()

## ✅ Checklist Keberhasilan

- [x] ✅ Database setup berhasil (`php artisan migrate:fresh --seed`)
- [x] ✅ Semua route MVC berfungsi dengan views
- [x] ✅ Controllers return view dengan `compact()` (bukan JSON)
- [x] ✅ Data terstruktur dikirim ke Blade templates
- [x] ✅ Eager loading untuk menghindari N+1 problem  
- [x] ✅ Views memiliki navigation antar halaman
- [x] ✅ Search & filter functionality working
- [x] ✅ `dd()` tersedia untuk debugging

## 🏷️ TODO Items untuk Peserta

### Controller Level:
```php
// TODO: panggil dd($authors) saat dev untuk memastikan shape sesuai
// TODO: validasi id (jika tidak ada → kembalikan author=null untuk view)
// TODO: tambahkan pencarian sederhana via query string q (opsional)
// TODO: batasi kolom (select) & map ke array kontrak data (jangan kirim model mentah)
```

### View Level:
```html
<!-- TODO: Implementasi pencarian -->
<!-- TODO: Implementasi filter -->
```

### Database Level:
```php
// TODO: Tambahkan index yang relevan (mis: index pada year untuk pencarian)
// TODO: Isi data seed tambahan untuk variasi query (>=5 book & 4 film) — opsional
```

### Routing Level:
```php
// TODO: Menambahkan middleware auth jika nanti dibutuhkan (jangan implement sekarang)
```

## 🎨 Features Working

### ✅ Real MVC with Database:
- **Authors List**: Show all authors dengan books count
- **Author Detail**: Author info + list of books  
- **Books List**: Books dengan search functionality
- **Book Detail**: Book info + author + film adaptations
- **Films List**: Films dengan filter by year
- **Film Detail**: Film info + source books + author  
- **Latest Film**: Show newest film by year

### ✅ User Experience:
- Clean, responsive UI dengan CSS styling
- Navigation links antar halaman
- Search & filter forms yang functional
- Error handling untuk data tidak ditemukan
- Loading dari database real dengan relasi

## 📋 MVC vs Demo Endpoints

| Feature | MVC Routes | Demo Routes |
|---------|------------|-------------|
| Response Type | HTML Views (Blade) | JSON |
| Data Source | Database via Eloquent | Mock data |
| URL Pattern | `/authors`, `/books` | `/demo/authors`, `/demo/books` |
| Navigation | HTML links & forms | API endpoints |
| User Experience | Web interface | Data inspection |

## 🚀 Pengembangan Lanjutan

Modul ini menunjukkan:
- ✅ **MVC Pattern** - Route → Controller → Model → View
- ✅ **Blade Templating** - Data rendering dengan compact()
- ✅ **Form Handling** - Search & filter via GET parameters
- ✅ **Database Relations** - Eager loading, withCount
- ✅ **Data Processing** - Array mapping untuk view consumption

Yang sengaja tidak dipakai di modul ini:
- **Filament Admin Panel** (fokus MVC fundamental)  
- **Livewire** (untuk interaktivitas advanced - lihat `08-Livewire.md`)
- **API Resources** (focus pada Views, bukan API)

---

**Perfect untuk pembelajaran MVC Laravel fundamental!** 🎯
