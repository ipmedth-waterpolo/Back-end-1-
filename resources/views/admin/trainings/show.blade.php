<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Details</title>
</head>
<body>
    <!-- Back Button -->
    <p>
        <a href="{{ route('admin.trainings') }}" class="btn">Back to Trainings</a>
    </p>

    <!-- Training Details -->
    <h1>Training Details</h1>

    <p><strong>Name:</strong> {{ $training->name }}</p>
    <p><strong>Created by:</strong> 
        <a href="{{ route('admin.users.show', $training->user->id) }}">
            {{ $training->user ? $training->user->name : 'Unknown User' }}
        </a>
    </p>
    <p><strong>Description:</strong> {{ $training->beschrijving }}</p>
    <p><strong>Total Duration:</strong> {{ $training->totale_duur }} minutes</p>
    <p><strong>Enabled:</strong> {{ $training->enabled ? 'Yes' : 'No' }}</p>
    <p><strong>Ratings:</strong> {{ $training->ratings ? $training->ratings : 'Not Rated' }}</p>

    <!-- Associated Exercises -->
    <h2>Exercises</h2>
    @if ($oefeningen->isEmpty())
        <p>No exercises are associated with this training.</p>
    @else
        <ul>
            @foreach ($oefeningen as $exercise)
                <li>
                    <a href="{{ route('admin.exercises.show', $exercise->id) }}">{{ $exercise->name }}</a> - {{ $exercise->duur }} minutes
                </li>
            @endforeach
        </ul>
    @endif

    <!-- Action Buttons -->
    <p>
        <form action="{{ route('admin.trainings.delete', $training->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn">Delete Training</button>
        </form>
    </p>

    <!-- Edit and Other Links -->
    <p>
        <a href="{{ route('admin.trainings.edit', $training->id) }}" class="btn">Edit Training</a>
    </p>

</body>
</html>
