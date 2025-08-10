#backend
# 📌 04 – Database Entity to Models

## 1) Pengantar
Setelah membuat tabel dengan migration, kita butuh **Model** untuk berinteraksi dengan data di tabel tersebut.  
Laravel menggunakan **Eloquent ORM** (Object Relational Mapping) sehingga kita bisa bekerja dengan data seperti objek PHP.

📂 Folder model: `app/Models/`

---

## 2) Membuat Model
Gunakan Artisan command:
```bash
php artisan make:model Article
```
Ini akan membuat file `app/Models/Article.php`:
```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'body'];
}
```
- `$fillable` → daftar kolom yang boleh di-*mass assign*.
- Nama model biasanya singular (`Article`) dan otomatis terhubung ke tabel plural (`articles`).

---

## 3) Menggunakan Model
### a) Mengambil Semua Data
```php
$articles = Article::all();
```

### b) Mengambil Data Berdasarkan ID
```php
$article = Article::find(1);
```

### c) Menambahkan Data
```php
Article::create([
    'title' => 'Judul Baru',
    'body' => 'Isi artikel...'
]);
```

### d) Mengupdate Data
```php
$article = Article::find(1);
$article->update(['title' => 'Judul Update']);
```

### e) Menghapus Data
```php
Article::destroy(1);
```

---

## 4) Relasi Antar Model
Eloquent juga mendukung relasi:
- **One to One** → `hasOne`, `belongsTo`
- **One to Many** → `hasMany`
- **Many to Many** → `belongsToMany`

Contoh One to Many:
```php
// Model User
public function articles()
{
    return $this->hasMany(Article::class);
}
```

---

## 5) Latihan
🎯 **Tujuan:**  
Menghubungkan tabel `articles` dengan model `Article` dan melakukan operasi CRUD.

📂 Langkah:
1. Pastikan tabel `articles` sudah ada (dari migration sebelumnya).
2. Buat model:
```bash
php artisan make:model Article
```
3. Tambahkan `$fillable = ['title', 'body'];`
4. Di `routes/web.php`, tambahkan route untuk menampilkan semua artikel:
```php
use App\Models\Article;

Route::get('/articles', function () {
    return Article::all();
});
```
5. Coba akses `http://127.0.0.1:8000/articles` untuk melihat data dalam format JSON.
6. Tambahkan route untuk membuat artikel baru:
```php
Route::get('/articles/create', function () {
    Article::create([
        'title' => 'Artikel dari Route',
        'body' => 'Ini artikel baru yang dibuat langsung dari route.'
    ]);
    return 'Artikel berhasil dibuat!';
});
```

---

💡 *Tips:*
- Gunakan Tinker untuk eksplorasi model:
```bash
php artisan tinker
```
- Di Tinker, bisa langsung:
```php
Article::all();
Article::create(['title' => 'Test', 'body' => 'Isi']);
```
- Relasi akan sangat berguna saat mulai menghubungkan beberapa tabel.
