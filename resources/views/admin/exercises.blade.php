<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Exercises</title>
</head>
<body>
    <!-- Back Button -->
    <p>
    <a href="{{ route('admin.dashboard') }}" class="btn">Back</a>
    </p>

    <h1>Exercises</h1>
    <a href="{{ route('admin.exercises.create') }}">+ Add New Exercise</a>
    <br>

    <!-- Display Flash Messages -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Exercises Table -->
    <table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Categorie</th>
                <th>Duur</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($exercises as $exercise)
                <tr>
                    <td>{{ $exercise->id }}</td>
                    <td><a href="{{ route('admin.exercises.show', $exercise->id) }}">{{ $exercise->name }}</a></td>
                    <td>
                        @if (is_array($exercise->categorie))
                            {{ implode(', ', $exercise->categorie) }}
                        @else
                            {{ $exercise->categorie }}
                        @endif
                    </td>
                    <td>{{ $exercise->duur }} mins</td>
                    <td>
                        <a href="{{ route('admin.exercises.show', $exercise->id) }}">View</a> |
                        <form action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
