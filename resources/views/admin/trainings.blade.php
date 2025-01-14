<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trainings</title>
</head>
<body>
    <!-- Back Button -->
    <p>
        <a href="{{ route('admin.dashboard') }}" class="btn">Back</a>
    </p>

    <h1>Trainings</h1>
    <a href="{{ route('admin.trainings.create') }}">+ Add New Training</a>
    <br>

    <!-- Display Flash Messages -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Trainings Table -->
    <table border="2">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Duration (mins)</th>
                <th>Enabled</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($trainings as $training)
                <tr>
                    <td>{{ $training->id }}</td>
                    <td><a href="{{ route('admin.trainings.show', $training->id) }}">{{ $training->name }}</a></td>
                    <td>{{ Str::limit($training->beschrijving, 50) }}</td>
                    <td>{{ $training->totale_duur }}</td>
                    <td>{{ $training->enabled ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.trainings.show', $training->id) }}">View</a> |
                        <a href="{{ route('admin.trainings.edit', $training->id) }}">edit</a> |
                        <form action="{{ route('admin.trainings.delete', $training->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete()">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        function confirmDelete() {
        // Toon een bevestigingspopup
            if (confirm("Weet je zeker dat je deze training wilt verwijderen?")) {
                // Verstuur het formulier alleen bij bevestiging
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
</body>
</html>
