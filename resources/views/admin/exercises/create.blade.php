<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Exercise</title>
</head>
<body>
    <!-- Back Button -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'">Back</button>
    </p>

    <h1>Create New Exercise</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Exercise Creation Form -->
    <form action="{{ route('admin.exercises.store') }}" method="POST">
        @csrf

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        <br>

        <label for="categorie">Categorie:</label>
        <input type="text" id="categorie" name="categorie" value="{{ old('categorie') }}" required>
        <br>

        <label for="onderdeel">Onderdeel:</label>
        <input type="text" id="onderdeel" name="onderdeel" value="{{ old('onderdeel') }}" required>
        <br>

        <label for="omschrijving">Omschrijving:</label>
        <textarea id="omschrijving" name="omschrijving">{{ old('omschrijving') }}</textarea>
        <br>

        <button type="submit">Create Exercise</button>
    </form>
</body>
</html>
