<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Details</title>
</head>
<body>
    <h1>{{ $user->name }}</h1>
    <p>Email: {{ $user->email }}</p>
    <p>Role: {{ $user->role }}</p>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ $user->name }}">
        
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ $user->email }}">
        
        <label for="role">Role</label>
        <input type="text" id="role" name="role" value="{{ $user->role }}">

        <button type="submit">Update</button>
    </form>

    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</body>
</html>
