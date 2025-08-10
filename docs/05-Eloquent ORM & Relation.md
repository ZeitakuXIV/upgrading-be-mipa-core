#backend
# 📌 05 – Eloquent ORM & Relation

## 1) Pengantar
Eloquent ORM (Object Relational Mapping) memudahkan kita menghubungkan data antar tabel menggunakan **relasi**.  
Dengan relasi, kita bisa mengambil data terkait hanya dengan memanggil properti atau method, tanpa query SQL manual.

---

## 2) Jenis Relasi di Eloquent

### a) One to One
Contoh: 1 User punya 1 Profile.
```php
// User.php
public function profile() {
    return $this->hasOne(Profile::class);
}

// Profile.php
public function user() {
    return $this->belongsTo(User::class);
}
```
Pemanggilan:
```php
$user = User::find(1);
$profile = $user->profile;
```

---

### b) One to Many
Contoh: 1 User punya banyak Article.
```php
// User.php
public function articles() {
    return $this->hasMany(Article::class);
}

// Article.php
public function user() {
    return $this->belongsTo(User::class);
}
```
Pemanggilan:
```php
$user = User::find(1);
$articles = $user->articles;
```

---

### c) Many to Many
Contoh: Artikel bisa punya banyak Tag, dan Tag bisa dipakai di banyak Artikel.
```php
// Article.php
public function tags() {
    return $this->belongsToMany(Tag::class);
}

// Tag.php
public function articles() {
    return $this->belongsToMany(Article::class);
}
```
Biasanya butuh tabel pivot `article_tag` untuk menyimpan relasi.

---

## 3) Eager Loading
Untuk mencegah **N+1 Problem**, gunakan eager loading:
```php
$users = User::with('articles')->get();
```
Ini akan langsung memuat semua artikel dari setiap user dalam 1 query tambahan.

---

## 4) Latihan
🎯 **Tujuan:**  
Membuat relasi One to Many antara `User` dan `Article`.

📂 Langkah:
1. Pastikan tabel `users` dan `articles` sudah ada.
2. Tambahkan kolom `user_id` di tabel `articles` lewat migration:
```php
$table->foreignId('user_id')->constrained()->onDelete('cascade');
```
3. Tambahkan relasi di model:
```php
// User.php
public function articles() {
    return $this->hasMany(Article::class);
}

// Article.php
public function user() {
    return $this->belongsTo(User::class);
}
```
4. Tambahkan route untuk menampilkan semua artikel beserta user-nya:
```php
Route::get('/articles', function () {
    return Article::with('user')->get();
});
```
5. Uji di browser → harus menampilkan artikel dengan data user terkait.

---

💡 *Tips:*
- Selalu gunakan `with()` untuk load relasi secara efisien.
- Nama method relasi biasanya **plural** untuk `hasMany()` dan **singular** untuk `belongsTo()`.

