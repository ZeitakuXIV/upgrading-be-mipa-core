#backend

# 📌 05a – Eloquent Basics (Query Dasar)

> Tambahan sebelum Relasi: operasi dasar ambil/simpan data pake Eloquent.  
> Docs resmi: [https://laravel.com/docs/eloquent](https://laravel.com/docs/eloquent)

---

## 1) Ambil Data

```php
use App\Models\Book;

// Semua data (hati-hati untuk tabel besar)
$all = Book::all();

// Ambil satu baris by PK
$one = Book::find(10);       // null jika tidak ada
$must = Book::findOrFail(10);// 404 jika tidak ada

// Ambil baris pertama hasil query
$first = Book::where('author', 'Martin')->first();
$firstOr = Book::where('author','Unknown')->firstOr(fn()=> new Book());

// Select kolom tertentu
$cols = Book::select('id','title','year')->get();

// Filter
$where   = Book::where('year', '>=', 2000)->get();
$orWhere = Book::where('author','Martin')->orWhere('author','Robert')->get();
$in      = Book::whereIn('year', [1999,2008,2014])->get();

// Urut & batasi
$sorted = Book::orderByDesc('created_at')->take(5)->get(); // atau ->limit(5)
```

## 2) Agregasi & Cek Eksistensi

```php
$count   = Book::where('year','>=',2000)->count();
$exists  = Book::where('title','Clean Code')->exists(); // true/false
$maxYear = Book::max('year'); // juga tersedia min/sum/avg
$onlyId  = Book::pluck('id'); // Collection id saja
```

## 3) Insert & Update

```php
// Insert cepat (pastikan $fillable di model)
$new = Book::create([
  'title'  => 'Clean Architecture',
  'author' => 'Robert C. Martin',
  'year'   => 2017,
  'summary'=> 'Prinsip arsitektur software…',
]);

// Update by instance
$book = Book::find(1);
$book->update(['year' => 2010]);

// Simpan manual
$book = new Book();
$book->title = 'Refactoring';
$book->author = 'Martin Fowler';
$book->year = 1999;
$book->save();

// Upsert praktis
$first = Book::firstOrCreate(
  ['title' => 'Domain-Driven Design'],         // kunci unik
  ['author' => 'Eric Evans','year'=>2003]      // nilai default jika belum ada
);
$upd = Book::updateOrCreate(
  ['title' => 'Refactoring'],                  // cari
  ['year' => 2018]                             // update jika ada / create jika tidak
);
```

## 4) Delete

```php
Book::destroy(5);               // by id
$book = Book::find(6);
$book?->delete();               // aman jika null
Book::where('year','<',1990)->delete(); // bulk delete (hati-hati)
```

## 5) Debug Cepat (dev only)

```php
$books = Book::where('year','>=',2000)->orderBy('year')->get();
dd($books->toArray()); // lihat data siap Blade

// Lihat SQL yang dihasilkan (quick & kotor)
$query = Book::where('year','>=',2000)->orderBy('year');
dd($query->toSql(), $query->getBindings());
```

---