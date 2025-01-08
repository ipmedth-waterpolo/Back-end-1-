<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Training</title>
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
</head>
<body>
    <p>
        <a href="{{ route('admin.trainings') }}" class="btn">Back to Trainings</a>
    </p>

    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <h1>Create Training</h1>

    <!-- Form for Creating Training -->
    <form action="{{ route('admin.trainings.store') }}" method="POST" onsubmit="updateTotalDuration()">
    @csrf

    <!-- Training Name -->
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <!-- Training Description -->
    <div>
        <label for="beschrijving">Description</label>
        <textarea id="beschrijving" name="beschrijving" rows="4" required>{{ old('beschrijving') }}</textarea>
    </div>

    <!-- Enabled Toggle -->
    <div>
        <!-- Hidden input to ensure the 'enabled' field is submitted as 'false' when unchecked -->
        <input type="hidden" name="enabled" value="0">
        <label for="enabled">Enabled</label>
        <input type="checkbox" id="enabled" name="enabled" value="1" {{ old('enabled') ? 'checked' : '' }}>
    </div>

    <!-- Ratings -->
    <div>
        <label for="ratings">Ratings (optional)</label>
        <input type="number" id="ratings" name="ratings" value="{{ old('ratings') }}" step="0.1" min="0" max="5">
    </div>

    <!-- Associated Exercises (Checkboxes) -->
    <div>
        <label>Associated Exercises</label>
        <div>
            @foreach ($exercises as $exercise)
                <div>
                    <input type="checkbox" name="oefeningIDs[]" value="{{ $exercise->id }}" 
                           id="exercise-{{ $exercise->id }}"
                           @if (in_array($exercise->id, old('oefeningIDs', []))) checked @endif
                           onclick="updateTotalDuration()">
                    <label for="exercise-{{ $exercise->id }}">{{ $exercise->name }} ({{ $exercise->duur }} minutes)</label>
                    <input type="hidden" id="duration-{{ $exercise->id }}" value="{{ $exercise->duur }}">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Hidden Total Duration Field (Not Displayed) -->
    <div style="display: none;">
        <input type="number" id="totale_duur" name="totale_duur" value="{{ old('totale_duur') }}">
    </div>

    <!-- Submit Button -->
    <div>
        <button type="submit">Create Training</button>
    </div>
</form>
</body>
</html>
