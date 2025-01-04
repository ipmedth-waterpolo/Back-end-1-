<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Exercise</title>
</head>
<body>
    <!-- Back Button -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'">Back</button>
    </p>

    <h1>Edit Exercise: {{ $exercise->name }}</h1>

    <!-- Update Form -->
    <form action="{{ route('admin.exercises.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name -->
        <label for="name"><strong>Name:</strong></label>
        <input type="text" id="name" name="name" value="{{ $exercise->name }}" required>
        <br><br>

        <!-- Enabled -->
        <label for="enabled"><strong>Enabled:</strong></label>
        <input type="checkbox" id="enabled" name="enabled" {{ $exercise->enabled ? 'checked' : '' }}>
        <br><br>

    <!-- Categorie -->
	<label for="categorie"><strong>Categorie:</strong></label>
	<select id="categorie" name="categorie" onchange="toggleCustomCategoryInput()">
		@php
			$categories = collect($exercises)->pluck('categorie')->unique()->filter()->toArray();
		@endphp
		@foreach ($categories as $category)
			<option value="{{ $category }}" {{ $exercise->categorie == $category ? 'selected' : '' }}>
				{{ $category }}
			</option>
		@endforeach
		<option value="custom" {{ $exercise->categorie == 'custom' ? 'selected' : '' }}>Other...</option>
	</select>
	<br><br>
	<input type="text" id="custom_categorie" name="custom_categorie" placeholder="Custom Category" style="display: none;">
	<br><br>

	<!-- Onderdeel -->
	<label for="onderdeel"><strong>Onderdeel:</strong></label>
	<select id="onderdeel" name="onderdeel" onchange="toggleCustomOnderdeelInput()">
		@php
			$onderdelen = collect($exercises)->pluck('onderdeel')->unique()->filter()->toArray();
		@endphp
		@foreach ($onderdelen as $onderdeel)
			<option value="{{ $onderdeel }}" {{ $exercise->onderdeel == $onderdeel ? 'selected' : '' }}>
				{{ $onderdeel }}
			</option>
		@endforeach
		<option value="custom" {{ $exercise->onderdeel == 'custom' ? 'selected' : '' }}>Other...</option>
	</select>
	<br><br>
	<input type="text" id="custom_onderdeel" name="custom_onderdeel" placeholder="Custom Onderdeel" style="display: none;">
	<br><br>

	<script>
		// Function to toggle the custom category input field
		function toggleCustomCategoryInput() {
			var categorySelect = document.getElementById('categorie');
			var customCategoryInput = document.getElementById('custom_categorie');

			if (categorySelect.value === 'custom') {
				customCategoryInput.style.display = 'block'; // Show custom input
			} else {
				customCategoryInput.style.display = 'none'; // Hide custom input
			}
		}

		// Function to toggle the custom onderdeel input field
		function toggleCustomOnderdeelInput() {
			var onderdeelSelect = document.getElementById('onderdeel');
			var customOnderdeelInput = document.getElementById('custom_onderdeel');

			if (onderdeelSelect.value === 'custom') {
				customOnderdeelInput.style.display = 'block'; // Show custom input
			} else {
				customOnderdeelInput.style.display = 'none'; // Hide custom input
			}
		}

		// Run the functions to ensure visibility on page load (if already selected as 'custom')
		window.onload = function() {
			toggleCustomCategoryInput();
			toggleCustomOnderdeelInput();
		};
	</script>


        <!-- Leeftijdsgroep -->
        <label><strong>Leeftijdsgroep:</strong></label>
        @php
            $allAgeGroups = ['O08', 'O10', 'O12', 'O14', 'O16', 'O18', 'volwassenen'];
        @endphp
        <div>
            @foreach ($allAgeGroups as $ageGroup)
                <label>
                    <input type="checkbox" name="leeftijdsgroep[]" value="{{ $ageGroup }}" 
                           {{ in_array($ageGroup, $exercise->leeftijdsgroep ?? []) ? 'checked' : '' }}>
                    {{ $ageGroup }}
                </label>
                <br>
            @endforeach
        </div>
        <br><br>


        <!-- Duur -->
        <label for="duur"><strong>Duur (in minutes):</strong></label>
        <input type="number" id="duur" name="duur" value="{{ $exercise->duur }}" required>
        <br><br>

        <!-- Minimale Aantal Spelers -->
        <label for="minimum_aantal_spelers"><strong>Minimum Aantal Spelers:</strong></label>
        <input type="number" id="minimum_aantal_spelers" name="minimum_aantal_spelers" value="{{ $exercise->minimum_aantal_spelers }}" required>
        <br><br>

        <!-- Benodigdheden -->
        <label for="benodigdheden"><strong>Benodigdheden:</strong></label>
        <textarea id="benodigdheden" name="benodigdheden" rows="3">{{ implode(', ', $exercise->benodigdheden ?? []) }}</textarea>
        <br><br>

        <!-- Water Nodig -->
        <label for="water_nodig"><strong>Water Nodig:</strong></label>
        <input type="checkbox" id="water_nodig" name="water_nodig" {{ $exercise->water_nodig ? 'checked' : '' }}>
        <br><br>

        <!-- Omschrijving -->
        <label for="omschrijving"><strong>Omschrijving:</strong></label>
        <textarea id="omschrijving" name="omschrijving" rows="5" required>{{ $exercise->omschrijving }}</textarea>
        <br><br>

        <!-- Variatie -->
        <label for="variatie"><strong>Variatie:</strong></label>
        <textarea id="variatie" name="variatie" rows="3">{{ $exercise->variatie }}</textarea>
        <br><br>

        <!-- Source -->
        <label for="source"><strong>Source:</strong></label>
        <input type="text" id="source" name="source" value="{{ $exercise->source }}">
        <br><br>

        <!-- Afbeeldingen -->
        <label for="afbeeldingen"><strong>Afbeeldingen:</strong></label>
        <textarea id="afbeeldingen" name="afbeeldingen" rows="3">{{ implode(', ', $exercise->afbeeldingen ?? []) }}</textarea>
        <br><br>

        <!-- Videos -->
        <label for="videos"><strong>Videos:</strong></label>
        <textarea id="videos" name="videos" rows="3">{{ implode(', ', $exercise->videos ?? []) }}</textarea>
        <br><br>

        <!-- Rating -->
        <label for="rating"><strong>Rating:</strong></label>
        <input type="number" id="rating" name="rating" value="{{ $exercise->rating }}" min="0" max="5" step="1">
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Update Exercise</button>
    </form>

    <!-- Delete Form -->
    <form action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        @method('DELETE')
        <button type="submit" style="background-color: red; color: white;">Delete Exercise</button>
    </form>

    <script>
        // Show custom input fields if "Other..." is selected
        document.getElementById('categorie').addEventListener('change', function () {
            document.getElementById('custom_categorie').style.display = this.value === 'custom' ? 'block' : 'none';
        });
        document.getElementById('onderdeel').addEventListener('change', function () {
            document.getElementById('custom_onderdeel').style.display = this.value === 'custom' ? 'block' : 'none';
        });
    </script>
</body>
</html>
