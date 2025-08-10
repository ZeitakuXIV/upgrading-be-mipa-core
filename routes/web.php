<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\DemoController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

// refer: 02-Basic Routing & MVC.md, (routing dasar & alur MVC)
// Modul studi kasus routes - MVC dengan Views (bukan API JSON)
// Authors routes
Route::get('authors', [AuthorController::class, 'index'])->name('authors.index');
Route::get('authors/{id}', [AuthorController::class, 'show'])->name('authors.show');

// Books routes
Route::get('books', [BookController::class, 'index'])->name('books.index');
Route::get('books/{id}', [BookController::class, 'show'])->name('books.show');

// Films routes
Route::get('films', [FilmController::class, 'index'])->name('films.index');
Route::get('films/{id}', [FilmController::class, 'show'])->name('films.show');
Route::get('films-latest', [FilmController::class, 'latest'])->name('films.latest');

// TODO: Menambahkan nama route (route name) konsisten ✓ (sudah ada di atas)
// TODO: Menambahkan middleware auth jika nanti dibutuhkan (jangan implement sekarang)
// Contoh untuk nanti: Route::middleware(['auth'])->group(function () { ... });

// Livewire Demo Route - Interactive Search Components
Route::get('livewire-demo', function () {
    return view('livewire-demo');
})->name('livewire.demo');

require __DIR__.'/auth.php';
