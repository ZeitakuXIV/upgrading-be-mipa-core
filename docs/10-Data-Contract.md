# Data Contract - Modul Studi Kasus Backend Laravel

## Kontrak Data (disepakati dengan FE)

> refer: 07-Data Structure & Debugging.md, (mapping ke array + dd() untuk verifikasi)

### Authors

#### Authors List (`GET /api/authors`)
```json
{
  "items": [
    {
      "id": 1,
      "name": "J.K. Rowling",
      "books_count": 2,
      "route": "http://localhost:8000/api/authors/1"
    }
  ]
}
```

#### Author Detail (`GET /api/authors/{id}`)
```json
{
  "author": {
    "id": 1,
    "name": "J.K. Rowling",
    "bio": "British author, best known for the Harry Potter series.",
    "books": [
      {
        "id": 1,
        "title": "Harry Potter and the Philosopher's Stone",
        "year": 1997,
        "route": "http://localhost:8000/api/books/1"
      }
    ]
  }
}
```

**Atau jika tidak ditemukan:**
```json
{
  "author": null
}
```

### Books

#### Books List (`GET /api/books`)
```json
{
  "items": [
    {
      "id": 1,
      "title": "Harry Potter and the Philosopher's Stone",
      "author": "J.K. Rowling",
      "year": 1997,
      "route": "http://localhost:8000/api/books/1",
      "added": "10 Aug 2025"
    }
  ]
}
```

#### Book Detail (`GET /api/books/{id}`)
```json
{
  "id": 1,
  "title": "Harry Potter and the Philosopher's Stone",
  "author": {
    "id": 1,
    "name": "J.K. Rowling"
  },
  "year": 1997,
  "summary": "The first book in the Harry Potter series.",
  "films": [
    {
      "id": 1,
      "title": "Harry Potter and the Philosopher's Stone (Film)",
      "year": 2001
    }
  ],
  "added": "10 Aug 2025"
}
```

**Atau jika tidak ditemukan:**
```json
{
  "book": null
}
```

### Films

#### Films List (`GET /api/films`)
```json
{
  "items": [
    {
      "id": 1,
      "title": "Harry Potter and the Philosopher's Stone (Film)",
      "year": 2001,
      "adapted_from_books": 1,
      "route": "http://localhost:8000/api/films/1"
    }
  ]
}
```

#### Film Detail (`GET /api/films/{id}`)
```json
{
  "id": 1,
  "title": "Harry Potter and the Philosopher's Stone (Film)",
  "author": {
    "id": 1,
    "name": "J.K. Rowling"
  },
  "year": 2001,
  "synopsis": "Film adaptation of the first Harry Potter book.",
  "books": [
    {
      "id": 1,
      "title": "Harry Potter and the Philosopher's Stone",
      "year": 1997,
      "author": "J.K. Rowling"
    }
  ]
}
```

#### Latest Film (`GET /api/films-latest`)
```json
{
  "id": 4,
  "title": "Inception",
  "author": {
    "id": 3,
    "name": "Christopher Nolan"
  },
  "year": 2010,
  "synopsis": "Original screenplay by Christopher Nolan about dreams within dreams."
}
```

**Atau jika tidak ada film:**
```json
{
  "film": null
}
```

## TODO untuk Debugging

```php
// TODO: panggil dd($payload) saat dev untuk memastikan shape sesuai
dd($payload);
```

## Query Parameters (Opsional)

- **Books**: `GET /api/books?q=harry` (pencarian berdasarkan title)
- **Films**: `GET /api/films?year=2001` (filter berdasarkan tahun)

## Error Handling

Semua endpoint mengembalikan HTTP 404 dengan payload `null` jika resource tidak ditemukan.

## Catatan Teknis

1. **Eager Loading**: Semua controller menggunakan `with()` untuk menghindari N+1 query problem
2. **Data Mapping**: Tidak mengirim model mentah, selalu di-map ke array sesuai kontrak
3. **Date Format**: Menggunakan format `d M Y` untuk tanggal yang user-friendly
4. **Route Names**: Semua route memiliki nama untuk konsistensi (`authors.index`, `books.show`, dll)
