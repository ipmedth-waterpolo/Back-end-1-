@extends('layouts.admin')

@section('title', 'Maak een Training') <!-- Stel de paginatitel in -->

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

    <h1>Maak Training</h1>

    <!-- Formulier voor het aanmaken van een training -->
    <form action="{{ route('admin.trainings.store') }}" method="POST" onsubmit="updateTotalDuration()">
    @csrf

    <!-- Naam van de Training -->
    <div>
        <label for="name">Naam</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
    </div>

    <!-- Beschrijving van de Training -->
    <div>
        <label for="beschrijving">Beschrijving</label>
        <textarea id="beschrijving" name="beschrijving" rows="4" required>{{ old('beschrijving') }}</textarea>
    </div>

    <!-- Ingeschakeld Toggle -->
    <div class="checkbox-container">
        <!-- Verborgen input om ervoor te zorgen dat het 'enabled'-veld als 'false' wordt verzonden als het niet is aangevinkt -->
        <input type="hidden" name="enabled" value="0">
        <label for="enabled">Ingeschakeld</label>
        <input type="checkbox" id="enabled" name="enabled" value="1" {{ old('enabled') ? 'checked' : '' }}>
    </div>

    <!-- Beoordeling -->
    <div>
        <label for="ratings">Beoordeling (optioneel)</label>
        <input type="number" id="ratings" name="ratings" value="{{ old('ratings') }}" step="0.1" min="0" max="5">
    </div>

    <!-- Gerelateerde Oefeningen (Checkboxen) -->
    <div class="checkbox-container">
        <label>Gerelateerde Oefeningen</label>
        <div>
            @foreach ($exercises as $exercise)
                <div>
                    <input type="checkbox" name="oefeningIDs[]" value="{{ $exercise->id }}" 
                           id="exercise-{{ $exercise->id }}"
                           @if (in_array($exercise->id, old('oefeningIDs', []))) checked @endif
                           onclick="updateTotalDuration()">
                    <label for="exercise-{{ $exercise->id }}">{{ $exercise->name }} ({{ $exercise->duur }} minuten)</label>
                    <input type="hidden" id="duration-{{ $exercise->id }}" value="{{ $exercise->duur }}">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Verborgen Totaal Duur Veld (Niet Weergegeven) -->
    <div style="display: none;">
        <input type="number" id="totale_duur" name="totale_duur" value="{{ old('totale_duur') }}">
    </div>

    <!-- Verstuurknop -->
    <div>
        <button type="submit">Maak Training</button>
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
        // Functie om de totale duur te berekenen op basis van geselecteerde oefeningen
        function updateTotalDuration() {
            let totalDuration = 0;

            // Doorloop alle aangevinkte checkboxes om de duur van de geselecteerde oefeningen op te tellen
            document.querySelectorAll('input[name="oefeningIDs[]"]:checked').forEach(function (checkbox) {
                let exerciseId = checkbox.value;
                let exerciseDuration = parseInt(document.getElementById('duration-' + exerciseId).value);
                totalDuration += exerciseDuration;
            });

            // Update het verborgen veld voor totale duur met de berekende waarde
            document.getElementById('totale_duur').value = totalDuration;
        }
</script>
@endsection
