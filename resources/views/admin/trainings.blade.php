<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Trainings</title>
</head>
<body>
    <h1>Trainings</h1>
    <a href="{{ route('admin.trainings.create') }}">+ Add New Training</a>
    <ul>
        @foreach ($trainings as $training)
            <li>
                <a href="{{ route('admin.trainings.show', $training->id) }}">{{ $training->name }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
