@extends('layouts.admin')

@section('title', 'Edit a Training') <!-- Set the page title -->

@section('content')
    <p>
        <a href="{{ route('admin.trainings') }}" class="btn">Terug naar Trainingen</a>
    </p>

    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <h1>Edit Training</h1>

    <!-- Form for Editing Training -->
    <form action="{{ route('admin.trainings.update', $training->id) }}" method="POST" onsubmit="updateTotalDuration()">
    @csrf
    @method('PUT')

    <!-- Training Name -->
    <div>
        <label for="name">Naam</label>
        <input type="text" id="name" name="name" value="{{ old('name', $training->name) }}" required>
    </div>

    <!-- Training Description -->
    <div>
        <label for="beschrijving">Omschrijving</label>
        <textarea id="beschrijving" name="beschrijving" rows="4" required>{{ old('beschrijving', $training->beschrijving) }}</textarea>
    </div>

    <!-- Enabled Toggle -->
    <div class="checkbox-container">
        <!-- Hidden input to ensure the 'enabled' field is submitted as 'false' when unchecked -->
        <input type="hidden" name="enabled" value="0">
        <label for="enabled">Geef weer</label>
        <input type="checkbox" id="enabled" name="enabled" value="1" {{ $training->enabled ? 'checked' : '' }}>
    </div>

    <!-- Ratings -->
    <div>
        <label for="ratings">Waardering (optioneel)</label>
        <input type="number" id="ratings" name="ratings" value="{{ old('ratings', $training->ratings) }}" step="0.1" min="0" max="5">
    </div>

<!-- Associated Exercises (Checkboxes) -->
<div class="checkbox-container">
    <label>Oefeningen</label>
    <div>
        @foreach ($exercises as $exercise)
            <div>
                <input type="checkbox" name="oefeningIDs[]" value="{{ $exercise->id }}" 
                       id="exercise-{{ $exercise->id }}"
                       @if (in_array($exercise->id, explode(',', $training->oefeningIDs ?? ''))) checked @endif
                       onclick="updateTotalDuration()">
                <label for="exercise-{{ $exercise->id }}">{{ $exercise->name }} ({{ $exercise->duur }} min)</label>
                <input type="hidden" id="duration-{{ $exercise->id }}" value="{{ $exercise->duur }}">
            </div>
        @endforeach
    </div>
</div>

    <!-- Hidden Total Duration Field (Not Displayed) -->
    <div style="display: none;">
        <input type="number" id="totale_duur" name="totale_duur" value="{{ old('totale_duur', $training->totale_duur) }}">
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit">Update Training</button>
    </div>
</form>

<p>
        <a href="{{ route('admin.trainings') }}" class="btn">Naar trainingen lijst</a>
    </p>

<br>
<br>
<br>
<br>

    <script>
        // Function to calculate the total duration based on selected exercises
        function updateTotalDuration() {
            let totalDuration = 0;

            // Iterate through all checkboxes to sum up the durations of selected exercises
            document.querySelectorAll('input[name="oefeningIDs[]"]:checked').forEach(function (checkbox) {
                let exerciseId = checkbox.value;
                let exerciseDuration = parseInt(document.getElementById('duration-' + exerciseId).value);
                totalDuration += exerciseDuration;
            });

            // Update the hidden total duration field with the calculated value
            document.getElementById('totale_duur').value = totalDuration;
        }
    </script>
@endsection