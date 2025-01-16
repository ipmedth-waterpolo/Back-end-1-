@extends('layouts.admin')

@section('title', 'Oefeningen')

@section('content')
    <!-- Terug knop -->
    <p>
        <a href="{{ route('admin.dashboard') }}" class="btn">Terug</a>
    </p>

    <h1>Oefeningen Beheren</h1>
    <a href="{{ route('admin.exercises.create') }}" class="btn">+ Nieuwe Oefening Toevoegen</a>
    <br><br>

    <!-- Flash Messages -->
    @if (session('success'))
        <p class="flash-message success">{{ session('success') }}</p>
    @elseif (session('error'))
        <p class="flash-message error">{{ session('error') }}</p>
    @endif

    @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Bestanden Uploaden -->
    <form action="{{ route('admin.exercises.upload') }}" method="POST" enctype="multipart/form-data" class="upload-form">
        @csrf
        <label for="jsonFile">Upload Oefeningen Bestand:</label>
        <input type="file" name="jsonFile" id="jsonFile" required>
        <span id="file-error" class="error"></span>
        <button type="submit" id="submit-btn" class="btn">Upload</button>
    </form>

    <!-- Oefeningen Tabel -->
    <div class="table-container"> 
    <table class="exercise-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Categorie</th>
                <th>Duur</th>
                <th>Acties</th>
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
                    <td>{{ $exercise->duur }} minuten</td>
                    <td>
                        <a href="{{ route('admin.exercises.show', $exercise->id) }}" class="btn">Bekijk</a> |
                        <form id="deleteForm" action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete()" class="btn-delete">Verwijderen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <br>
    <br>
    <br>
    <br>

    <script>
        // Bestanden validatie
        document.addEventListener('DOMContentLoaded', function () {
            const exerciseFileInput = document.getElementById('jsonFile');
            const errorMessage = document.getElementById('file-error');
            const submitButton = document.getElementById('submit-btn');

            // Toegestane bestandtypes
            const allowedFileTypes = ['application/json'];

            exerciseFileInput.addEventListener('change', function () {
                const file = exerciseFileInput.files[0];

                if (file) {
                    if (!allowedFileTypes.includes(file.type)) {
                        errorMessage.textContent = 'Ongeldig bestandstype. Upload een JSON bestand.';
                        submitButton.disabled = true;
                    } else {
                        errorMessage.textContent = '';
                        submitButton.disabled = false;
                    }
                }
            });
        });

        function confirmDelete() {
            if (confirm("Weet je zeker dat je deze oefening wilt verwijderen?")) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection
