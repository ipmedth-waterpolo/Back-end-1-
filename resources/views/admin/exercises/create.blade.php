<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Exercise</title>
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

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <h1>Create New Exercise</h1>

    <!-- Create Exercise Form -->
    <form action="{{ route('admin.exercises.store') }}" method="POST">
        @csrf

        <!-- Name -->
        <label for="name"><strong>Name:</strong></label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Enabled -->
        <label for="enabled"><strong>Enabled:</strong></label>
        <input type="checkbox" id="enabled" name="enabled" {{ old('enabled') ? 'checked' : '' }}>
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
                           {{ in_array($category, old('categorie', [])) ? 'checked' : '' }}>
                    {{ $category }}
                </label>
                <br>
            @endforeach
        </div>
        <input type="text" id="new_category" placeholder="Add new category">
        <button type="button" onclick="addNewCategory()">Add Category</button>
        @error('categorie') <span style="color: red;">{{ $message }}</span> @enderror
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
                           {{ in_array($onderdeel, old('onderdeel', [])) ? 'checked' : '' }}>
                    {{ $onderdeel }}
                </label>
                <br>
            @endforeach
        </div>
        <input type="text" id="new_onderdeel" placeholder="Add new onderdeel">
        <button type="button" onclick="addNewOnderdeel()">Add Onderdeel</button>
        @error('onderdeel') <span style="color: red;">{{ $message }}</span> @enderror
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
                           {{ in_array($ageGroup, old('leeftijdsgroep', [])) ? 'checked' : '' }}>
                    {{ $ageGroup }}
                </label>
                <br>
            @endforeach
        </div>
        @error('leeftijdsgroep') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Duur -->
        <label for="duur"><strong>Duur (in minutes):</strong></label>
        <input type="number" id="duur" name="duur" value="{{ old('duur') }}" required>
        @error('duur') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Minimum Aantal Spelers -->
        <label for="minimum_aantal_spelers"><strong>Minimum Aantal Spelers:</strong></label>
        <input type="number" id="minimum_aantal_spelers" name="minimum_aantal_spelers" value="{{ old('minimum_aantal_spelers') }}" required>
        @error('minimum_aantal_spelers') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Benodigdheden -->
        <label for="benodigdheden"><strong>Benodigdheden:</strong></label>
        <textarea id="benodigdheden" name="benodigdheden" rows="3">{{ old('benodigdheden') }}</textarea>
        @error('benodigdheden') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Water Nodig -->
        <label for="water_nodig"><strong>Water Nodig:</strong></label>
        <input type="checkbox" id="water_nodig" name="water_nodig" {{ old('water_nodig') ? 'checked' : '' }}>
        @error('water_nodig') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Omschrijving -->
        <label for="omschrijving"><strong>Omschrijving:</strong></label>
        <textarea id="omschrijving" name="omschrijving" rows="5" required>{{ old('omschrijving') }}</textarea>
        @error('omschrijving') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Variatie -->
        <label for="variatie"><strong>Variatie:</strong></label>
        <textarea id="variatie" name="variatie" rows="3">{{ old('variatie') }}</textarea>
        <br><br>

        <!-- Icon -->
        <label for="icon"><strong>Icon (Upload or URL):</strong></label>
        <input type="text" id="icon" name="icon" placeholder="Enter icon URL or upload below" value="{{ old('icon') }}">
        <br><br>
        <input type="file" id="icon_upload" name="icon_upload" accept="image/*">
        @error('icon') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Afbeeldingen -->
        <label for="afbeeldingen"><strong>Afbeeldingen:</strong></label>
        <textarea id="afbeeldingen" name="afbeeldingen" rows="3">{{ old('afbeeldingen') }}</textarea>
        @error('afbeeldingen') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Videos -->
        <label for="videos"><strong>Videos:</strong></label>
        <textarea id="videos" name="videos" rows="3">{{ old('videos') }}</textarea>
        @error('videos') <span style="color: red;">{{ $message }}</span> @enderror
        <br><br>

        <!-- Source -->
        <label for="source"><strong>Source:</strong></label>
        <input type="text" id="source" name="source" value="{{ old('source') }}">
        <br><br>

        <!-- Rating -->
        <label for="rating"><strong>Rating:</strong></label>
        <input type="number" id="rating" name="rating" value="{{ old('rating') }}" min="0" max="5" step="1">
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Create Exercise</button>
    </form>
</body>
</html>
