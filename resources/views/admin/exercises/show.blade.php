<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Show Exercise</title>
    <script>
        function addNewCategory() {
            var newCategoryInput = document.getElementById('new_category');
            var newCategoryValue = newCategoryInput.value.trim();

            if (newCategoryValue !== '') {
                var categoryContainer = document.getElementById('category_container');

                var label = document.createElement('label');
                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'categorie[]';
                checkbox.value = newCategoryValue;
                checkbox.checked = true;

                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(' ' + newCategoryValue));

                categoryContainer.appendChild(label);
                categoryContainer.appendChild(document.createElement('br'));

                newCategoryInput.value = '';
            }
        }

        function addNewOnderdeel() {
            var newOnderdeelInput = document.getElementById('new_onderdeel');
            var newOnderdeelValue = newOnderdeelInput.value.trim();

            if (newOnderdeelValue !== '') {
                var onderdeelContainer = document.getElementById('onderdeel_container');

                var label = document.createElement('label');
                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'onderdeel[]';
                checkbox.value = newOnderdeelValue;
                checkbox.checked = true;

                label.appendChild(checkbox);
                label.appendChild(document.createTextNode(' ' + newOnderdeelValue));

                onderdeelContainer.appendChild(label);
                onderdeelContainer.appendChild(document.createElement('br'));

                newOnderdeelInput.value = '';
            }
        }
    </script>
</head>
<body>
    <!-- Back Button -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'">Back</button>
    </p>

    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

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
        <label><strong>Categorie:</strong></label>
        <div id="category_container">
            @php
                $categories = collect($exercises)->pluck('categorie')->flatten()->unique()->filter()->toArray();
            @endphp
            @foreach ($categories as $category)
                <label>
                    <input type="checkbox" name="categorie[]" value="{{ $category }}" 
                        {{ is_array($exercise->categorie) && in_array($category, $exercise->categorie) ? 'checked' : '' }}>
                    {{ $category }}
                </label>
                <br>
            @endforeach
        </div>
        <input type="text" id="new_category" placeholder="Add new category">
        <button type="button" onclick="addNewCategory()">Add Category</button>
        <br><br>

        <!-- Onderdeel -->
        <label><strong>Onderdeel:</strong></label>
        <div id="onderdeel_container">
            @php
                $onderdelen = collect($exercises)->pluck('onderdeel')->flatten()->unique()->filter()->toArray();
            @endphp
            @foreach ($onderdelen as $onderdeel)
                <label>
                    <input type="checkbox" name="onderdeel[]" value="{{ $onderdeel }}" 
                        {{ is_array($exercise->onderdeel) && in_array($onderdeel, $exercise->onderdeel) ? 'checked' : '' }}>
                    {{ $onderdeel }}
                </label>
                <br>
            @endforeach
        </div>
        <input type="text" id="new_onderdeel" placeholder="Add new onderdeel">
        <button type="button" onclick="addNewOnderdeel()">Add Onderdeel</button>
        <br><br>

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
        <textarea id="benodigdheden" name="benodigdheden" rows="3">
            {{ is_array($exercise->benodigdheden) ? implode(', ', $exercise->benodigdheden) : $exercise->benodigdheden }}
        </textarea>
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
        <textarea id="afbeeldingen" name="afbeeldingen" rows="3">{{ is_array($exercise->afbeeldingen) ? implode(', ', $exercise->afbeeldingen) : $exercise->afbeeldingen }}</textarea>
        <br><br>

        <!-- Videos -->
        <label for="videos"><strong>Videos:</strong></label>
        <textarea id="videos" name="videos" rows="3">{{ is_array($exercise->videos) ? implode(', ', $exercise->videos) : $exercise->videos }}</textarea>
        <br><br>

        <!-- Rating -->
        <label for="rating"><strong>Rating:</strong></label>
        <input type="number" id="rating" name="rating" value="{{ $exercise->rating }}" min="0" max="5" step="1">
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Update Exercise</button>
    </form>

<!-- Delete Form -->
<form id="deleteForm" action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST" style="margin-top: 20px;">
    @csrf
    @method('DELETE')
    <button type="button" onclick="confirmDelete()" style="background-color: red; color: white;">Delete Exercise</button>
</form>

<script>
    function confirmDelete() {
        // Toon een bevestigingspopup
        if (confirm("Weet je zeker dat je deze oefening wilt verwijderen?")) {
            // Als de gebruiker bevestigt, verstuur het formulier
            document.getElementById('deleteForm').submit();
        }
        // Anders gebeurt er niets (actie wordt geannuleerd)
    }
</script>
</body>
</html>
