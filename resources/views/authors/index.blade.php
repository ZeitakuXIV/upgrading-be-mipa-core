<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors - Studi Kasus</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .count { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('authors.index') }}">Authors</a>
        <a href="{{ route('books.index') }}">Books</a>
        <a href="{{ route('films.index') }}">Films</a>
    </div>

    <div class="header">
        <h1>Authors List</h1>
        <p class="count">Total: {{ count($authors) }} authors</p>
    </div>

    @foreach($authors as $author)
    <div class="card">
        <h3>
            <a href="{{ route('authors.show', $author['id']) }}">{{ $author['name'] }}</a>
        </h3>
        <p class="count">{{ $author['books_count'] }} books</p>
        @if($author['bio'])
            <p>{{ Str::limit($author['bio'], 100) }}</p>
        @endif
    </div>
    @endforeach
</body>
</html>
