@extends('layouts.admin')

@section('title', 'Oefening') <!-- Set the page title -->

@section('content')
    <!-- Back Button -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'" class="btn-back">Back</button>
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

    <h1>Edit Exercise: {{ $exercise->name }}</h1>

    <!-- Update Form -->
    <form action="{{ route('admin.exercises.update', $exercise->id) }}" method="POST" class="form-update">
        @csrf
        @method('PUT')

        <div class="form-group">
            <!-- Name -->
            <label for="name"><strong>Name:</strong></label>
            <input type="text" id="name" name="name" value="{{ $exercise->name }}" required class="form-control">
        </div>

        <div class="checkbox-container">
            <!-- Enabled -->
            <label for="enabled"><strong>Enabled:</strong></label>
            <input type="checkbox" id="enabled" name="enabled" {{ $exercise->enabled ? 'checked' : '' }} class="form-control-checkbox">
        </div>

        <div class="checkbox-container">
            <!-- Categorie -->
            <label><strong>Categories:</strong></label>
            <div id="category_container">
                @php
                    $categories = collect($exercises)->pluck('categorie')->flatten()->unique()->filter()->toArray();
                @endphp
                @foreach ($categories as $category)
                    <label>
                        <input type="checkbox" name="categorie[]" value="{{ $category }}" 
                            {{ is_array($exercise->categorie) && in_array($category, $exercise->categorie) ? 'checked' : '' }} class="form-control-checkbox">
                        {{ $category }}
                    </label>
                    <br>
                @endforeach
            </div>
            <input type="text" id="new_category" placeholder="Add new category" class="form-control">
            <button type="button" onclick="addNewCategory()" class="btn-add">Add Category</button>
        </div>

        <div class="checkbox-container">
            <!-- Onderdeel -->
            <label><strong>Parts:</strong></label>
            <div id="onderdeel_container">
                @php
                    $onderdelen = collect($exercises)->pluck('onderdeel')->flatten()->unique()->filter()->toArray();
                @endphp
                @foreach ($onderdelen as $onderdeel)
                    <label>
                        <input type="checkbox" name="onderdeel[]" value="{{ $onderdeel }}" 
                            {{ is_array($exercise->onderdeel) && in_array($onderdeel, $exercise->onderdeel) ? 'checked' : '' }} class="form-control-checkbox">
                        {{ $onderdeel }}
                    </label>
                    <br>
                @endforeach
            </div>
            <input type="text" id="new_onderdeel" placeholder="Add new part" class="form-control">
            <button type="button" onclick="addNewOnderdeel()" class="btn-add">Add Part</button>
        </div>

        <div class="checkbox-container">
            <!-- Leeftijdsgroep -->
            <label><strong>Age Group:</strong></label>
            @php
                $allAgeGroups = ['O08', 'O10', 'O12', 'O14', 'O16', 'O18', 'volwassenen'];
            @endphp
            <div>
                @foreach ($allAgeGroups as $ageGroup)
                    <label>
                        <input type="checkbox" name="leeftijdsgroep[]" value="{{ $ageGroup }}" 
                               {{ in_array($ageGroup, $exercise->leeftijdsgroep ?? []) ? 'checked' : '' }} class="form-control-checkbox">
                        {{ $ageGroup }}
                    </label>
                    <br>
                @endforeach
            </div>
        </div>

        <div class="form-group">
            <!-- Duur -->
            <label for="duur"><strong>Duration (in minutes):</strong></label>
            <input type="number" id="duur" name="duur" value="{{ $exercise->duur }}" required class="form-control">
        </div>

        <div class="form-group">
            <!-- Minimale Aantal Spelers -->
            <label for="minimum_aantal_spelers"><strong>Minimum Number of Players:</strong></label>
            <input type="number" id="minimum_aantal_spelers" name="minimum_aantal_spelers" value="{{ $exercise->minimum_aantal_spelers }}" required class="form-control">
        </div>

        <div class="form-group">
            <!-- Benodigdheden -->
            <label for="benodigdheden"><strong>Materials:</strong></label>
            <textarea id="benodigdheden" name="benodigdheden" rows="3" class="form-control">{{ is_array($exercise->benodigdheden) ? implode(', ', $exercise->benodigdheden) : $exercise->benodigdheden }}</textarea>
        </div>

        <div class="form-group">
            <!-- Water Nodig -->
            <label for="water_nodig"><strong>Water Required:</strong></label>
            <input type="checkbox" id="water_nodig" name="water_nodig" {{ $exercise->water_nodig ? 'checked' : '' }} class="form-control-checkbox">
        </div>

        <div class="form-group">
            <!-- Omschrijving -->
            <label for="omschrijving"><strong>Description:</strong></label>
            <textarea id="omschrijving" name="omschrijving" rows="5" required class="form-control">{{ $exercise->omschrijving }}</textarea>
        </div>

        <div class="form-group">
            <!-- Variatie -->
            <label for="variatie"><strong>Variation:</strong></label>
            <textarea id="variatie" name="variatie" rows="3" class="form-control">{{ $exercise->variatie }}</textarea>
        </div>

        <div class="form-group">
            <!-- Source -->
            <label for="source"><strong>Source:</strong></label>
            <input type="text" id="source" name="source" value="{{ $exercise->source }}" class="form-control">
        </div>

        <div class="form-group">
            <!-- Afbeeldingen -->
            <label for="afbeeldingen"><strong>Images:</strong></label>
            <textarea id="afbeeldingen" name="afbeeldingen" rows="3" class="form-control">{{ is_array($exercise->afbeeldingen) ? implode(', ', $exercise->afbeeldingen) : $exercise->afbeeldingen }}</textarea>
        </div>

        <div class="form-group">
            <!-- Videos -->
            <label for="videos"><strong>Videos:</strong></label>
            <textarea id="videos" name="videos" rows="3" class="form-control">{{ is_array($exercise->videos) ? implode(', ', $exercise->videos) : $exercise->videos }}</textarea>
        </div>

        <div class="form-group">
            <!-- Rating -->
            <label for="rating"><strong>Rating:</strong></label>
            <input type="number" id="rating" name="rating" value="{{ $exercise->rating }}" min="0" max="5" step="1" class="form-control">
        </div>

        <div class="form-group">
            <!-- Submit Button -->
            <button type="submit" class="btn-submit">Update Exercise</button>
        </div>
    </form>

    <!-- Delete Form -->
    <form id="deleteForm" action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST" class="form-delete">
        @csrf
        @method('DELETE')
        <button type="button" onclick="confirmDelete()" class="btn-delete">Delete Exercise</button>
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

        function confirmDelete() {
            if (confirm("Are you sure you want to delete this exercise?")) {
                document.getElementById('deleteForm').submit();
            }
        }
    </script>
@endsection
