<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Film - Studi Kasus</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .header { margin-bottom: 30px; }
        .card { background: #f9f9f9; padding: 20px; margin: 10px 0; border-radius: 8px; }
        .nav { margin-bottom: 20px; }
        .nav a { margin-right: 15px; text-decoration: none; color: #007bff; }
        .nav a:hover { text-decoration: underline; }
        .highlight { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; border-radius: 10px; }
        .error { color: #dc3545; background: #f8d7da; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="nav">
        <a href="{{ route('films.index') }}">← Back to Films</a>
        <a href="{{ route('authors.index') }}">Authors</a>
        <a href="{{ route('books.index') }}">Books</a>
    </div>

    <div class="header">
        <h1>Latest Film</h1>
        <p>The most recent film by year</p>
    </div>

    @if($film)
    <div class="highlight">
        <h2>{{ $film['title'] }}</h2>
        <p><strong>Director/Author:</strong> {{ $film['author']['name'] }}</p>
        <p><strong>Year:</strong> {{ $film['year'] }}</p>
        @if($film['synopsis'])
            <p>{{ $film['synopsis'] }}</p>
        @endif
    </div>
    @else
    <div class="error">
        <h2>No Films Found</h2>
        <p>No films are available in the database.</p>
    </div>
    @endif
</body>
</html>
