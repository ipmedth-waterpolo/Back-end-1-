<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Exercises</title>
</head>
<body>
    <h1>Exercises</h1>
    <a href="{{ route('admin.exercises.create') }}">+ Add New Exercise</a>
    <ul>
        @foreach ($exercises as $exercise)
            <li>
                <a href="{{ route('admin.exercises.show', $exercise->id) }}">{{ $exercise->name }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
