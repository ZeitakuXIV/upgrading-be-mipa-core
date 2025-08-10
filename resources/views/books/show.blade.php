<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $book ? $book['title'] : 'Book Not Found' }} - BookController Reference</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .meta { color: #666; font-size: 0.9em; }
        .films-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; }
        .error { color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('books.index') }}">← Back to Books</a>
        <a href="{{ route('authors.index') }}">Authors</a>
        <a href="{{ route('films.index') }}">Films</a>
    </div>

    @if($book)
    <div class="header">
        <h1>{{ $book['title'] }}</h1>
        <p><strong>Year:</strong> {{ $book['year'] }}</p>
        @if(isset($book['summary']) && $book['summary'])
            <p>{{ $book['summary'] }}</p>
        @endif
    </div>

    <!-- Learning Note untuk Students -->
    <div style="background: #e7f3ff; padding: 15px; margin: 20px 0; border-radius: 8px;">
        <h3>💡 Controller Data Structure (Basic Show)</h3>
        <p>BookController show() mengembalikan array dengan keys: 'id', 'title', 'year', 'summary', 'route'</p>
        <pre style="background: #f1f3f4; padding: 10px; border-radius: 4px; font-size: 12px;">
// BookController show() method:
return [
    'id' => $book->id,
    'title' => $book->title,
    'year' => $book->year,
    'summary' => $book->summary,
    'route' => route('books.show', $book->id)
];
        </pre>
        <p><strong>🚀 Advanced:</strong> Lihat method showWithAuthor() dan showWithRelations() untuk implementasi dengan relasi!</p>
    </div>

    @else
    <div class="error">
        <h2>Book Not Found</h2>
        <p>The requested book could not be found.</p>
    </div>
    @endif
</body>
</html>
