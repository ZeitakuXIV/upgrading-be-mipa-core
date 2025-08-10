<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $author ? $author['name'] : 'Author Not Found' }} - Studi Kasus</title>
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
        <a href="{{ route('authors.index') }}">← Back to Authors</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('films.index') }}">Films</a>
    </div>

    @if($author)
    <div class="header">
        <h1>{{ $author['name'] }}</h1>
        @if($author['bio'])
            <p>{{ $author['bio'] }}</p>
        @endif
    </div>

    <h3>Books by {{ $author['name'] }}</h3>
    @if(count($author['books']) > 0)
    <div class="books-grid">
        @foreach($author['books'] as $book)
        <div class="card">
            <h4>
                <a href="{{ $book['route'] }}">{{ $book['title'] }}</a>
            </h4>
            <p><strong>Year:</strong> {{ $book['year'] }}</p>
        </div>
        @endforeach
    </div>
    @else
    <p>No books found for this author.</p>
    @endif

    @else
    <div class="error">
        <h2>Author Not Found</h2>
        <p>The requested author could not be found.</p>
    </div>
    @endif
</body>
</html>
