@extends('layouts.admin')

@section('title', 'Nieuwe Oefening')

@section('content')
    <!-- Terug knop -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'" class="btn-back">Terug</button>
    </p>

    @if ($errors->any())
    <div class="error-messages">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <h1>Maak Nieuwe Oefening</h1>

    <form action="{{ route('admin.exercises.store') }}" method="POST" class="form-create">
    @csrf
    <div class="form-group">
        <!-- Name -->
        <label for="name"><strong>Name:</strong></label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-control">
    </div>

    <div class="checkbox-container">
        <!-- Categories -->
        <label><strong>Categories:</strong></label>
        <div id="category_container">
            @php
                $categories = collect($exercises)->pluck('categorie')->flatten()->unique()->filter()->toArray();
            @endphp
            @foreach ($categories as $category)
                <label>
                    <input type="checkbox" name="categorie[]" value="{{ $category }}" 
                        {{ in_array($category, old('categorie', [])) ? 'checked' : '' }} class="form-control-checkbox">
                    {{ $category }}
                </label>
                <br>
            @endforeach
        </div>
        <input type="text" id="new_category" placeholder="Add new category" class="form-control">
        <button type="button" onclick="addNewCategory()" class="btn-add">Add Category</button>
    </div>

    <div class="checkbox-container">
        <!-- Parts -->
        <label><strong>Parts:</strong></label>
        <div id="onderdeel_container">
            @php
                $onderdelen = collect($exercises)->pluck('onderdeel')->flatten()->unique()->filter()->toArray();
            @endphp
            @foreach ($onderdelen as $onderdeel)
                <label>
                    <input type="checkbox" name="onderdeel[]" value="{{ $onderdeel }}" 
                        {{ in_array($onderdeel, old('onderdeel', [])) ? 'checked' : '' }} class="form-control-checkbox">
                    {{ $onderdeel }}
                </label>
                <br>
            @endforeach
        </div>
        <input type="text" id="new_onderdeel" placeholder="Add new part" class="form-control">
        <button type="button" onclick="addNewOnderdeel()" class="btn-add">Add Part</button>
    </div>

    <div class="checkbox-container">
        <!-- Age Groups -->
        <label><strong>Age Groups:</strong></label>
        @php
            $allAgeGroups = ['O08', 'O10', 'O12', 'O14', 'O16', 'O18', 'volwassenen'];
        @endphp
        @foreach ($allAgeGroups as $ageGroup)
            <label>
                <input type="checkbox" name="leeftijdsgroep[]" value="{{ $ageGroup }}" 
                       {{ in_array($ageGroup, old('leeftijdsgroep', [])) ? 'checked' : '' }} class="form-control-checkbox">
                {{ $ageGroup }}
            </label>
            <br>
        @endforeach
    </div>

    <div class="form-group">
        <!-- Duration -->
        <label for="duur"><strong>Duration (in minutes):</strong></label>
        <input type="number" id="duur" name="duur" value="{{ old('duur') }}" required class="form-control" min="1">
    </div>

    <div class="form-group">
        <!-- Minimum Players -->
        <label for="minimum_aantal_spelers"><strong>Minimum Number of Players:</strong></label>
        <input type="number" id="minimum_aantal_spelers" name="minimum_aantal_spelers" value="{{ old('minimum_aantal_spelers') }}" required class="form-control" min="1">
    </div>

    <div class="form-group">
        <!-- Materials -->
        <label for="benodigdheden"><strong>Benodigdheden</strong></label>
        <textarea id="benodigdheden" name="benodigdheden" rows="3" class="form-control">{{ old('benodigdheden') }}</textarea>
    </div>

    <div class="form-group">
        <!-- Water Required -->
        <label for="water_nodig"><strong>Water Required:</strong></label>
        <input type="checkbox" id="water_nodig" name="water_nodig" value="1" {{ old('water_nodig') ? 'checked' : '' }} class="form-control">
    </div>

    <div class="form-group">
        <!-- Description -->
        <label for="omschrijving"><strong>Description:</strong></label>
        <textarea id="omschrijving" name="omschrijving" rows="5" required class="form-control">{{ old('omschrijving') }}</textarea>
    </div>

    <div class="form-group">
        <!-- Variation -->
        <label for="variatie"><strong>Variation:</strong></label>
        <textarea id="variatie" name="variatie" rows="3" class="form-control">{{ old('variatie') }}</textarea>
    </div>

    <div class="form-group">
        <!-- Source -->
        <label for="source"><strong>Source:</strong></label>
        <input type="text" id="source" name="source" value="{{ old('source') }}" class="form-control">
    </div>

    <div class="form-group">
        <!-- Images -->
        <label for="afbeeldingen"><strong>Images:</strong></label>
        <textarea id="afbeeldingen" name="afbeeldingen" rows="3" class="form-control">{{ old('afbeeldingen') }}</textarea>
    </div>

    <div class="form-group">
        <!-- Videos -->
        <label for="videos"><strong>Videos:</strong></label>
        <textarea id="videos" name="videos" rows="3" class="form-control">{{ old('videos') }}</textarea>
    </div>

    <div class="form-group">
        <!-- Rating -->
        <label for="rating"><strong>Rating:</strong></label>
        <input type="number" id="rating" name="rating" value="{{ old('rating') }}" min="1" max="5" step="1" class="form-control">
    </div>

    <div class="form-group">
        <!-- Submit Button -->
        <button type="submit" class="btn-submit">Create Exercise</button>
    </div>
</form>


    <p>
        <a href="{{ route('admin.exercises') }}" class="btn">Naar oefeningen lijst</a>
    </p>

    <br>
    <br>
    <br>
    <br>

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
    </script>
@endsection
