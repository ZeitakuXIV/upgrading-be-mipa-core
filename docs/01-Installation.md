# Backend Laravel - Installation & Application Status

## 🚀 Current Application Status
Aplikasi study case ini sudah **siap digunakan** dengan fitur-fitur berikut:
- ✅ **Database Setup:** Authors, Books, Films dengan relasi
- ✅ **Models:** Author, Book, Film dengan Eloquent relationships  
- ✅ **Controllers:** AuthorController (basic), BookController (reference), FilmController (challenge)
- ✅ **Views:** Books (working), Films (challenge template)
- ✅ **Livewire:** Basic search components
- ✅ **Routes:** RESTful routes untuk semua entities
- ✅ **Seeder:** Data sample untuk testing

**🎯 Learning Path:** BookController sebagai referensi → FilmController sebagai challenge untuk students

---

## 1) Quick Start (Aplikasi Sudah Ada)
Jika aplikasi sudah ada, langsung jalankan:
```bash
cd upgrading-be-mipa-core
php artisan migrate:fresh --seed
php artisan serve
```
Akses: `http://127.0.0.1:8000`

---

## 2) Fresh Installation Steps
### Step A) Instalasi XAMPP  
   Pilih versi **PHP 8.1** atau lebih baru.
2. Install XAMPP di lokasi default (misal `C:\xampp`).
3. Jalankan **XAMPP Control Panel** → Start **Apache** & **MySQL**.

---

## 2) Instalasi Composer
1. Download Composer: [https://getcomposer.org/download/](https://getcomposer.org/download/)  
2. Saat instalasi, arahkan ke file `php.exe` di `C:\xampp\php\php.exe`.
3. Cek instalasi:
```bash
composer -V
```
---

## 3) Clone Repository Laravel
```bash
git clone https://github.com/username/nama-repo.git mipa-core
cd mipa-core
```

---
## 4) Install Dependency
```bash
composer install
```
---

## 5) Konfigurasi `.env`
- Copy file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
- Sesuaikan database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mipa_core
DB_USERNAME=root
DB_PASSWORD=
```

---

## 6) Buat Database di phpMyAdmin
1. Akses `http://localhost/phpmyadmin`.
2. Buat database baru `mipa_core`.

---

## 7) Generate Key & Jalankan Migration
```bash
php artisan key:generate
php artisan migrate --seed
```

---

## 8) Jalankan Laravel
```bash
php artisan serve
```
Akses di browser: `http://127.0.0.1:8000`
