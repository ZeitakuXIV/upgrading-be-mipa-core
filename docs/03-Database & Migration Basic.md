#backend
# 📌 03 – Database & Migration Basic

## 1) Pengantar
Laravel menyediakan **Migration** untuk mengelola struktur database secara terkontrol menggunakan kode.  
Keuntungannya:
- Bisa version control (tercatat di Git).
- Bisa di-*rollback* jika salah.
- Konsisten antara semua developer.

📂 Folder migration: `database/migrations/`

---

## 2) Koneksi ke Database
Atur koneksi di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=namadb
DB_USERNAME=root
DB_PASSWORD=
```
> Jika pakai XAMPP, `root` default tanpa password.

---

## 3) Membuat Migration
Gunakan Artisan command:
```bash
php artisan make:migration create_posts_table
```
Akan membuat file di `database/migrations/` dengan isi dasar:
```php
public function up(): void
{
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('content');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('posts');
}
```
- `up()` → menjalankan perubahan (membuat tabel).
- `down()` → membatalkan perubahan (menghapus tabel).

---

## 4) Menjalankan Migration
```bash
php artisan migrate
```
Untuk membatalkan migrasi:
```bash
php artisan migrate:rollback
```

---

## 5) Seeder – Mengisi Data Awal
Seeder digunakan untuk mengisi data otomatis.
```bash
php artisan make:seeder PostSeeder
```
Contoh isi `database/seeders/PostSeeder.php`:
```php
public function run(): void
{
    DB::table('posts')->insert([
        'title' => 'Post Pertama',
        'content' => 'Ini adalah konten post pertama',
        'created_at' => now(),
        'updated_at' => now()
    ]);
}
```
Jalankan:
```bash
php artisan db:seed --class=PostSeeder
```

---

## 6) Latihan
### 🎯 Tujuan
Membuat tabel `articles` dan mengisi 2 data contoh.

📂 Langkah:
1. Buat migration:
```bash
php artisan make:migration create_articles_table
```
2. Edit migration:
```php
$table->id();
$table->string('title');
$table->text('body');
$table->timestamps();
```
3. Jalankan migrasi:
```bash
php artisan migrate
```
4. Buat seeder:
```bash
php artisan make:seeder ArticleSeeder
```
5. Isi dengan 2 data contoh.
6. Jalankan seeder:
```bash
php artisan db:seed --class=ArticleSeeder
```
7. Cek data di database.

---

💡 *Tips:*
- Gunakan `php artisan migrate:fresh --seed` untuk reset database dan jalankan semua seeder.
- Simpan semua perubahan struktur lewat migration, jangan langsung ubah via phpMyAdmin.
