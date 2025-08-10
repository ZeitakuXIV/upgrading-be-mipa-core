<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books - Studi Kasus</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .search { margin-bottom: 20px; }
        .search input { padding: 8px; width: 300px; border: 1px solid #ddd; border-radius: 4px; }
        .search button { padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .meta { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('authors.index') }}">Authors</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('films.index') }}">Films</a>
    </div>

    <div class="header">
        <h1>📚 Books List (Reference Implementation)</h1>
        <p class="meta">Total: {{ count($books) }} books</p>
        <p style="color: #007bff;">🔧 Controller: BookController.php → Method: index()</p>
    </div>

    <!-- TODO: Implementasi pencarian -->
    <div class="search">
        <form method="GET" action="{{ route('books.index') }}">
            <input type="text" name="q" placeholder="Search books..." value="{{ request('q') }}">
            <button type="submit">Search</button>
            @if(request('q'))
                <a href="{{ route('books.index') }}" style="margin-left: 10px;">Clear</a>
            @endif
        </form>
    </div>

    @foreach($books as $book)
    <div class="card">
        <h3>
            <a href="{{ $book['route'] }}">{{ $book['title'] }}</a>
        </h3>
        <p><strong>Year:</strong> {{ $book['year'] }}</p>
    </div>
    @endforeach

    <!-- Learning Note untuk Students -->
    <div style="background: #e7f3ff; padding: 15px; margin-top: 30px; border-radius: 8px;">
        <h3>💡 Controller Data Structure</h3>
        <p>BookController mengembalikan array dengan keys: 'id', 'title', 'year', 'route'</p>
        <pre style="background: #f1f3f4; padding: 10px; border-radius: 4px; font-size: 12px;">
// BookController index() method:
$books = $booksData->map(function ($book) {
    return [
        'id' => $book->id,
        'title' => $book->title,
        'year' => $book->year,
        'route' => route('books.show', $book->id)
    ];
})->toArray();
        </pre>
    </div>
</body>
</html>
