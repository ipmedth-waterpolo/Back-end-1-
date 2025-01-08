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
                <th>Icon</th>
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

<!-- Icon Column -->
<td>
    @if ($exercise->icon)
        @if (filter_var($exercise->icon, FILTER_VALIDATE_URL))
            <!-- If the icon is a URL (like FontAwesome icon) -->
            <img src="{{ $exercise->icon }}" alt="Icon" style="width: 50px; height: 50px;">
        @else
            <!-- If the icon is a base64-encoded image -->
            <img src="data:image/png;base64,{{ base64_encode(Storage::disk('public')->get($exercise->icon)) }}" alt="Icon" style="width: 50px; height: 50px;">
        @endif
    @else
        No Icon
    @endif
</td>

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
