@extends('layouts.admin')

@section('title', 'Training overview') <!-- Set the page title -->

@section('content')
    <!-- Back Button -->
    <p>
        <a href="{{ route('admin.dashboard') }}" class="btn">Terug</a>
    </p>

    <h1>Trainings</h1>
    <a href="{{ route('admin.trainings.create') }}" class="btn">+ Maak een nieuwe Training</a>
    <br>

    <!-- Display Flash Messages -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Trainings Table -->
    <div class="table-container"> 
    <table class="exercise-table">        <thead>
            <tr>
                <th>ID</th>
                <th>Naam</th>
                <th>Omschrijving</th>
                <th>Duratie (mins)</th>
                <th>Beschikbaar</th>
                <th>Acties</th>
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
                        <a href="{{ route('admin.trainings.show', $training->id) }}" class="btn">View</a> |
                        <a href="{{ route('admin.trainings.edit', $training->id) }}" class="btn">edit</a> |
                        <form action="{{ route('admin.trainings.delete', $training->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete()" class="btn-delete">verwijderen</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
    <script>
        function confirmDelete() {
        // Toon een bevestigingspopup
            if (confirm("Weet je zeker dat je deze training wilt verwijderen?")) {
                // Verstuur het formulier alleen bij bevestiging
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection