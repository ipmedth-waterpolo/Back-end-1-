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

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- File Upload Form -->
    <form action="{{ route('admin.exercises.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="jsonFile">Upload Exercises File:</label>
        <input type="file" name="jsonFile" id="jsonFile" required>
        <span id="file-error" class="error"></span>
        <button type="submit" id="submit-btn">Upload</button>
    </form>

    <br>

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
                        <form id="deleteForm" action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST" style="display:inline;">
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
        document.addEventListener('DOMContentLoaded', function () {
            const exerciseFileInput = document.getElementById('jsonFile');
            const errorMessage = document.getElementById('file-error');
            const submitButton = document.getElementById('submit-btn');

            // Allowed file types
            const allowedFileTypes = ['application/json'];

            exerciseFileInput.addEventListener('change', function () {
                const file = exerciseFileInput.files[0];

                if (file) {
                    // Check if the file type is valid
                    if (!allowedFileTypes.includes(file.type)) {
                        errorMessage.textContent = 'Invalid file type. Please upload a JSON file.';
                        submitButton.disabled = true; // Disable the submit button
                    } else {
                        errorMessage.textContent = ''; // Clear the error message
                        submitButton.disabled = false; // Enable the submit button
                    }
                }
            });
        });

    function confirmDelete() {
        // Toon een bevestigingspopup
        if (confirm("Weet je zeker dat je deze oefening wilt verwijderen?")) {
            // Verstuur het formulier alleen bij bevestiging
            document.getElementById('deleteForm').submit();
        }
    }
    </script>
</body>
</html>
