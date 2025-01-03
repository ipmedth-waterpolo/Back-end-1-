<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Choose Option</title>
</head>
<body>
    <h1>Select an option</h1>
    <ul>
        <li><a href="{{ route('admin.users') }}">Manage Users</a></li>
        <li><a href="{{ route('admin.trainings') }}">Manage Trainings</a></li>
        <li><a href="{{ route('admin.exercises') }}">Manage Exercises</a></li>
    </ul>
</body>
</html>
