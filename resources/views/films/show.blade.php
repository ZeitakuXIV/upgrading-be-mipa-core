<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $film ? $film['title'] : 'Film Not Found' }} - FilmController Challenge</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .books-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; }
        .error { color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('films.index') }}">← Back to Films</a>
        <a href="{{ route('authors.index') }}">Authors</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('films.latest') }}">Latest Film</a>
    </div>

    @if($film)
    <div class="header">
        <h1>{{ $film['title'] }}</h1>
        <p><strong>Year:</strong> {{ $film['year'] }}</p>
        @if(isset($film['synopsis']) && $film['synopsis'])
            <p>{{ $film['synopsis'] }}</p>
        @endif
    </div>

    <!-- Challenge Instructions untuk Students -->
    <div style="background: #fff3cd; padding: 15px; margin: 20px 0; border-radius: 8px; border: 1px solid #ffc107;">
        <h3>🎯 Challenge: FilmController show() Method</h3>
        <p>Implementasikan method show() di FilmController untuk menampilkan detail film:</p>
        <pre style="background: #f1f3f4; padding: 10px; border-radius: 4px; font-size: 12px;">
// FilmController show() method target:
public function show($id) {
    $film = Film::find($id);

    if (!$film) {
        return redirect()->route('films.index')
            ->with('error', 'Film tidak ditemukan');
    }

    $film = [
        'id' => $film->id,
        'title' => $film->title,
        'year' => $film->year,
        'synopsis' => $film->synopsis,
        'route' => route('films.show', $film->id)
    ];

    return compact('film');
}
        </pre>
        <p><strong>📁 Reference:</strong> Lihat BookController::show() method sebagai contoh!</p>
    </div>

    @else
    <div class="error">
        <h2>Film Not Found</h2>
        <p>The requested film could not be found.</p>
    </div>
    @endif
</body>
</html>
