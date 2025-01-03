<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
</head>
<body>
    <h1>Users</h1>
    <a href="{{ route('admin.users.create') }}">+ Add New User</a>
    <ul>
        @foreach ($users as $user)
            <li>
                <a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a>
            </li>
        @endforeach
    </ul>
</body>
</html>
