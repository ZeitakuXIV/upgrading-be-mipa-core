# Modul Livewire - Pengenalan Komponen Reaktif

## Apa itu Livewire?

Laravel Livewire adalah framework untuk membuat interface yang reaktif dengan menggunakan PHP tanpa perlu JavaScript yang kompleks. Dengan Livewire, kamu bisa membuat aplikasi yang responsif dan interaktif tanpa reload halaman.

## Konsep Dasar

### 1. Reaktif artinya apa?
- Ketika data berubah, tampilan otomatis ikut berubah
- Tidak perlu refresh halaman atau submit form manual
- User experience jadi lebih smooth dan modern

### 2. Cara Kerja Sederhana
```
User mengetik → Data berubah → Component ter-update → Tampilan berubah
```

Semua terjadi secara otomatis tanpa reload halaman!

## File yang Dibuat

### 1. Component Book Search (Contoh)
**File: `app/Livewire/BookSearch.php`**

```php
<?php

namespace App\Livewire;

use App\Models\Book;
use Livewire\Component;

class BookSearch extends Component
{
    // Property yang bisa diakses dari view
    public $cari = '';

    // Method yang dipanggil ketika property $cari berubah
    public function updatedCari()
    {
        // Logic tambahan jika diperlukan
    }

    public function render()
    {
        // Query berdasarkan input user
        $books = Book::with('author')
            ->when($this->cari, function ($query) {
                return $query->where('title', 'like', '%' . $this->cari . '%');
            })
            ->get();

        return view('livewire.book-search', ['books' => $books]);
    }
}
```

**File: `resources/views/livewire/book-search.blade.php`**

```blade
<input 
    type="text" 
    wire:model.live="cari" 
    placeholder="Ketik judul buku..." 
    class="form-input"
>

@foreach($books as $book)
    <div>{{ $book->title }}</div>
@endforeach
```

### 2. Component Film Search (Challenge untuk Students)
**File: `app/Livewire/FilmSearch.php`**

Component ini sengaja belum selesai. Students harus mengimplementasikan method-method berikut:
- `cariFilm()`
- `resetFilter()` 
- `toggleForm()`
- Query conditional di method `render()`

## Directive Livewire yang Penting

### 1. Data Binding
```blade
<!-- Real-time binding - update setiap kali mengetik -->
<input wire:model.live="cari">

<!-- Lazy binding - update saat blur/enter -->
<input wire:model.lazy="cari">

<!-- Debounced - tunggu jeda 300ms -->
<input wire:model.live.debounce.300ms="cari">
```

### 2. Event Handling
```blade
<!-- Panggil method -->
<button wire:click="simpan">Simpan</button>

<!-- Panggil method dengan parameter -->
<button wire:click="hapus({{ $id }})">Hapus</button>

<!-- Toggle form -->
<button wire:click="toggleForm">
    {{ $showForm ? 'Sembunyikan' : 'Tampilkan' }}
</button>
```

### 3. Loading States
```blade
<!-- Loading indicator -->
<div wire:loading>
    Sedang mencari...
</div>

<!-- Loading pada element tertentu -->
<button wire:loading.class="opacity-50">
    Cari
</button>
```

## Lifecycle Methods

```php
class ExampleComponent extends Component
{
    public $nama = '';

    // Dipanggil saat component pertama kali dimuat
    public function mount()
    {
        $this->nama = 'Default';
    }

    // Dipanggil saat property $nama berubah
    public function updatedNama($value)
    {
        // Validasi atau logic tambahan
        if (strlen($value) < 3) {
            $this->nama = '';
        }
    }

    // Dipanggil setiap kali component di-render
    public function render()
    {
        return view('livewire.example');
    }
}
```

## Cara Menggunakan

### 1. Akses Demo
Buka browser dan kunjungi: `http://127.0.0.1:8000/livewire-demo`

### 2. Test Components
- **Tab Buku**: Contoh yang sudah jadi, coba ketik di input pencarian
- **Tab Film**: Challenge untuk students, perlu implementasi

### 3. Buat Component Baru
```bash
php artisan make:livewire NamaComponent
```

Ini akan membuat 2 file:
- `app/Livewire/NamaComponent.php` - Logic component
- `resources/views/livewire/nama-component.blade.php` - Template view

## Challenge Film Component

### Yang Harus Diimplementasikan:

#### 1. Method `resetFilter()`
```php
public function resetFilter()
{
    $this->judul = '';
    $this->tahun = '';
    $this->pengarang = '';
}
```

#### 2. Method `toggleForm()`
```php
public function toggleForm()
{
    $this->showForm = !$this->showForm;
}
```

#### 3. Query Conditional di `render()`
```php
$films = $films->when($this->judul, function($query) {
    return $query->where('title', 'like', '%' . $this->judul . '%');
});

$films = $films->when($this->tahun, function($query) {
    return $query->where('year', $this->tahun);
});

$films = $films->when($this->pengarang, function($query) {
    return $query->where('author_id', $this->pengarang);
});
```

## Best Practices

### 1. Gunakan Query Conditional
```php
// Bagus - hanya filter jika ada value
->when($this->search, function($query) {
    return $query->where('title', 'like', '%' . $this->search . '%');
})

// Tidak bagus - selalu filter meski kosong
->where('title', 'like', '%' . $this->search . '%')
```

### 2. Eager Loading untuk Performance
```php
// Bagus - load relasi sekaligus
Book::with('author')->get();

// Tidak bagus - N+1 query problem
Book::all(); // lalu akses $book->author di loop
```

### 3. Berikan Feedback ke User
```blade
<!-- Loading state -->
<div wire:loading>Sedang memuat...</div>

<!-- Empty state -->
@forelse($books as $book)
    <!-- tampilkan buku -->
@empty
    <div>Tidak ada buku ditemukan</div>
@endforelse

<!-- Counter hasil -->
<p>Ditemukan {{ $books->count() }} buku</p>
```

## Troubleshooting

### Error Umum:

#### 1. "Component not found"
```bash
# Pastikan component sudah dibuat
php artisan make:livewire ComponentName
```

#### 2. "Property not found"
```php
// Pastikan property public
public $search = ''; // ✓
private $search = ''; // ✗
```

#### 3. "Method not found"
```php
// Method harus public
public function cari() { } // ✓
private function cari() { } // ✗
```

## Kesimpulan

Livewire memungkinkan kita membuat aplikasi modern dan reaktif tanpa perlu JavaScript framework yang kompleks. Dengan PHP dan Blade template yang sudah familiar, kita bisa membuat user experience yang smooth dan interaktif.

Kunci utama Livewire:
- **Properties** yang reactive (`wire:model`)
- **Methods** untuk handle events (`wire:click`)
- **Lifecycle hooks** untuk logic tambahan
- **Query conditional** untuk filtering data

Selamat belajar dan eksperimen dengan Livewire! 🚀
