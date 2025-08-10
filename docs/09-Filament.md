# 🛠 Filament – Admin CRUD untuk Book

> Tujuan: Punya **panel admin** untuk kelola data Book tanpa nulis banyak UI.  
> Asumsi: Tabel `books` dan model `App\Models\Book` sudah ada (`id`, `title`, `author`, `year`, `summary`, `created_at`).

---

## 1) Instalasi
```bash
composer require filament/filament
```

> Filament (v3) otomatis men-setup route panel admin (default: `/admin`) dan butuh **auth** Laravel aktif.

Jika project belum ada login Laravel:
```bash
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
# jalankan npm bila perlu (untuk UI Breeze):
# npm install && npm run dev
```

---

## 2) Buat User Admin
```bash
php artisan make:filament-user
```
Ikuti prompt: nama, email, password → user ini bisa login ke `/admin`.

> Default Filament menggunakan guard `web` + policy/authorization Laravel. Di tahap upgrading ini cukup pakai user admin tanpa role kompleks.

---

## 3) Generate Resource Book
```bash
php artisan make:filament-resource Book
```
Perintah ini membuat:
```
app/Filament/Resources/BookResource.php
app/Filament/Resources/BookResource/Pages/ListBooks.php
app/Filament/Resources/BookResource/Pages/CreateBook.php
app/Filament/Resources/BookResource/Pages/EditBook.php
```

Akses panel: `http://127.0.0.1:8000/admin` → login → lihat menu **Books**.

---

## 4) Konfigurasi Form & Table
Buka `app/Filament/Resources/BookResource.php` lalu sesuaikan:

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookResource\Pages;
use App\Models\Book;
use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Resource;
use Filament\Forms\Form;
use Filament\Tables\Table;

class BookResource extends Resource
{
    protected static ?string $model = Book::class;

    // (opsional) atur ikon & label di sidebar
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Content'; // grup di sidebar

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('author')
                ->label('Author')
                ->required()
                ->maxLength(255),

            Forms\Components\TextInput::make('year')
                ->label('Year')
                ->numeric()
                ->minValue(0)
                ->maxValue(3000)
                ->required(),

            Forms\Components\Textarea::make('summary')
                ->label('Summary')
                ->rows(6)
                ->columnSpanFull(), // full width di form
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Author')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('year')
                    ->label('Year')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // bisa disembunyikan
            ])
            ->filters([
                // contoh filter by year (opsional)
                Tables\Filters\SelectFilter::make('year')
                    ->options(fn () => Book::query()
                        ->select('year')->distinct()->orderByDesc('year')->pluck('year','year')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBooks::route('/'),
            'create' => Pages\CreateBook::route('/create'),
            'edit'   => Pages\EditBook::route('/{record}/edit'),
        ];
    }
}
```

---

## 5) Proteksi Akses (sederhana)
- Pastikan hanya user login yang bisa akses `/admin` (default Filament sudah pakai middleware auth).
- Untuk tahap upgrading, cukup **gunakan user admin** dari langkah 2.  
- (Opsional) Tambah **Policy** jika ingin batasi per-aksi.

Contoh cepat Policy (opsional):
```bash
php artisan make:policy BookPolicy --model=Book
```
Di `AuthServiceProvider` daftarkan policy (Laravel 10+ auto discover; jika tidak, map manual).  
Di tahap ini, boleh dilewati agar tetap simple.

---

## 6) Sinkron dengan Halaman Publik
- **Admin (Filament)**: CRUD data Book.  
- **Publik (Blade/Livewire)**: baca data Book (list/detail) dari materi sebelumnya.  
- Artinya: isi/ubah Book di Filament → otomatis tampil di `/books` dan `/books/{id}`.

---

## 7) Checklist Selesai
- [ ] Bisa login ke `/admin` dengan user admin.  
- [ ] Menu **Books** muncul di sidebar.  
- [ ] Create / Edit / Delete Book **berjalan**.  
- [ ] Kolom tabel bisa **search** dan **sort**.  
- [ ] Form field sesuai (title, author, year, summary).

---

## 8) Troubleshooting Cepat
- **Tidak bisa login / redirect ke login terus**  
  - Pastikan `APP_URL` benar di `.env`, session driver valid (`SESSION_DRIVER=file`).  
  - Coba `php artisan optimize:clear`.
- **Menu Books tidak muncul**  
  - Pastikan `BookResource` modelnya `App\Models\Book`.  
  - Cek namespace & penamaan file.
- **Error ikon / UI**  
  - Jalankan `php artisan vendor:publish --tag=filament-config` jika butuh custom; biasanya tidak perlu.

---

## 9) Bonus Kecil (opsional)
- Tambah **global search** untuk Book:
  - Di `BookResource`, tambahkan:
    ```php
    protected static ?string $recordTitleAttribute = 'title';
    ```
- Tambah **relation manager** (jika nanti Book punya relasi, mis. Tags).

