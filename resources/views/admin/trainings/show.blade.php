@extends('layouts.admin')

@section('title', 'Training Detail') <!-- Set the page title -->

@section('content')
    <!-- Back Button -->
    <p>
        <a href="{{ route('admin.trainings') }}" class="btn">Back to Trainings</a>
    </p>

    <!-- Training Details -->
    <h1>Training Details</h1>

    <p><strong>Naam:</strong> {{ $training->name }}</p>
    <p><strong>Gemaakt door:</strong> 
        <a href="{{ route('admin.users.show', $training->user->id) }}">
            {{ $training->user ? $training->user->name : 'Unknown User' }}
        </a>
    </p>
    <p><strong>Omschrijving:</strong> {{ $training->beschrijving }}</p>
    <p><strong>Totale duur:</strong> {{ $training->totale_duur }} minutes</p>
    <p><strong>Beschikbaar:</strong> {{ $training->enabled ? 'Yes' : 'No' }}</p>
    <!-- <p><strong>Waardering:</strong> {{ $training->ratings ? $training->ratings : 'Not Rated' }}</p> -->

    <!-- Associated Exercises -->
    <h2>Exercises</h2>
    @if ($oefeningen->isEmpty())
        <p>No exercises are associated with this training.</p>
    @else
        <ul>
            @foreach ($oefeningen as $exercise)
                <li>
                    <a href="{{ route('admin.exercises.show', $exercise->id) }}" class="btn">{{ $exercise->name }}</a> - {{ $exercise->duur }} min
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Action Buttons -->
    <p>
        <form action="{{ route('admin.trainings.delete', $training->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-delete">Verwijder</button>
        </form>
    </p>

    <!-- Edit and Other Links -->
    <p>
        <a href="{{ route('admin.trainings.edit', $training->id) }}" class="btn">Edit Training</a>
    </p>
    @endsection