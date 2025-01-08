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

    <h1>Create New Exercise</h1>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Create Exercise Form -->
    <form action="{{ route('admin.exercises.store') }}" method="POST">
        @csrf

        <!-- Name -->
        <label for="name"><strong>Name:</strong></label>
        <input type="text" id="name" name="name" required>
        <br><br>

        <!-- Categorie -->
        <label><strong>Categorie:</strong></label>
        <div id="category_container">
            @php
                // Get unique categories from exercises
                $categories = collect($exercises)->pluck('categorie')->flatten()->unique()->filter()->toArray();
            @endphp
            @foreach ($categories as $category)
                <label>
                    <input type="checkbox" name="categorie[]" value="{{ $category }}">
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
                // Get unique onderdelen from exercises
                $onderdelen = collect($exercises)->pluck('onderdeel')->flatten()->unique()->filter()->toArray();
            @endphp
            @foreach ($onderdelen as $onderdeel)
                <label>
                    <input type="checkbox" name="onderdeel[]" value="{{ $onderdeel }}">
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
                    <input type="checkbox" name="leeftijdsgroep[]" value="{{ $ageGroup }}">
                    {{ $ageGroup }}
                </label>
                <br>
            @endforeach
        </div>
        <br><br>

        <!-- Duur -->
        <label for="duur"><strong>Duur (in minutes):</strong></label>
        <input type="number" id="duur" name="duur" required>
        <br><br>

        <!-- Minimum Aantal Spelers -->
        <label for="minimum_aantal_spelers"><strong>Minimum Aantal Spelers:</strong></label>
        <input type="number" id="minimum_aantal_spelers" name="minimum_aantal_spelers" required>
        <br><br>

        <!-- Benodigdheden -->
        <label for="benodigdheden"><strong>Benodigdheden:</strong></label>
        <textarea id="benodigdheden" name="benodigdheden" rows="3"></textarea>
        <br><br>

        <!-- Water Nodig -->
        <label for="water_nodig"><strong>Water Nodig:</strong></label>
        <input type="checkbox" id="water_nodig" name="water_nodig">
        <br><br>

        <!-- Omschrijving -->
        <label for="omschrijving"><strong>Omschrijving:</strong></label>
        <textarea id="omschrijving" name="omschrijving" rows="5" required></textarea>
        <br><br>

        <!-- Variatie -->
        <label for="variatie"><strong>Variatie:</strong></label>
        <textarea id="variatie" name="variatie" rows="3"></textarea>
        <br><br>

        <!-- Source -->
        <label for="source"><strong>Source:</strong></label>
        <input type="text" id="source" name="source">
        <br><br>

        <!-- Afbeeldingen -->
        <label for="afbeeldingen"><strong>Afbeeldingen:</strong></label>
        <textarea id="afbeeldingen" name="afbeeldingen" rows="3"></textarea>
        <br><br>

        <!-- Videos -->
        <label for="videos"><strong>Videos:</strong></label>
        <textarea id="videos" name="videos" rows="3"></textarea>
        <br><br>

        <!-- Rating -->
        <label for="rating"><strong>Rating:</strong></label>
        <input type="number" id="rating" name="rating" min="0" max="5" step="1">
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Create Exercise</button>
    </form>
</body>
</html>
