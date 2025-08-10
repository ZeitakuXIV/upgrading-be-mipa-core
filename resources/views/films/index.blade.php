<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Films - Studi Kasus</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .filter { margin-bottom: 20px; }
        .filter input, .filter select { padding: 8px; margin-right: 10px; border: 1px solid #ddd; border-radius: 4px; }
        .filter button { padding: 8px 15px; background: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .meta { color: #666; font-size: 0.9em; }
        .badge { background: #28a745; color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8em; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('authors.index') }}">Authors</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('films.index') }}">Films</a>
        <a href="{{ route('films.latest') }}">Latest Film</a>
    </div>

    <div class="header">
        <h1>🎬 Films List (Student Challenge)</h1>
        <p class="meta">Total: {{ count($films) }} films</p>
        <p style="color: #dc3545;">🎯 Challenge: Implementasikan FilmController berdasarkan BookController!</p>
    </div>

    <!-- Learning Challenge untuk Students -->
    <div style="background: #fff3cd; padding: 15px; margin-bottom: 20px; border-radius: 8px; border: 1px solid #ffc107;">
        <h3>🚀 Challenge: Implementasi FilmController</h3>
        <p>Gunakan BookController sebagai referensi, implementasikan:</p>
        <ul style="margin: 10px 0; padding-left: 20px;">
            <li>FilmController::index() - Return array dengan keys: id, title, year, route</li>
            <li>FilmController::show() - Return single film data</li>
            <li>Pattern: Film::select() → map() → toArray() → compact()</li>
        </ul>
        <p><strong>📁 File:</strong> <code>app/Http/Controllers/FilmController.php</code></p>
        <p><strong>🔗 Reference:</strong> <code>app/Http/Controllers/BookController.php</code></p>
    </div>

    <!-- TODO: Implementasi filter -->
    <div class="filter">
        <form method="GET" action="{{ route('films.index') }}">
            <input type="number" name="year" placeholder="Filter by year..." value="{{ request('year') }}">
            <button type="submit">Filter</button>
            @if(request('year'))
                <a href="{{ route('films.index') }}" style="margin-left: 10px;">Clear</a>
            @endif
        </form>
    </div>

    @foreach($films as $film)
    <div class="card">
        <h3>
            <a href="{{ $film['route'] }}">{{ $film['title'] }}</a>
        </h3>
        <p><strong>Year:</strong> {{ $film['year'] }}</p>
    </div>
    @endforeach

    <!-- Implementation Notes -->
    <div style="background: #f8f9fa; padding: 15px; margin-top: 30px; border-radius: 8px; border: 1px solid #e9ecef;">
        <h3>💡 Expected Film Data Structure</h3>
        <pre style="background: #f1f3f4; padding: 10px; border-radius: 4px; font-size: 12px;">
// FilmController should return:
$films = $filmsData->map(function ($film) {
    return [
        'id' => $film->id,
        'title' => $film->title,
        'year' => $film->year,
        'route' => route('films.show', $film->id)
    ];
})->toArray();

return compact('films');
        </pre>
    </div>
</body>
</html>
