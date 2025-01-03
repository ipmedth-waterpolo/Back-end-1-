<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Exercise Details</title>
</head>
<body>
    <h1>{{ $exercise->name }}</h1>
    <p>Description: {{ $exercise->description }}</p>

    <form action="{{ route('admin.exercises.update', $exercise->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ $exercise->name }}">
        
        <label for="description">Description</label>
        <textarea id="description" name="description">{{ $exercise->description }}</textarea>

        <button type="submit">Update</button>
    </form>

    <form action="{{ route('admin.exercises.delete', $exercise->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</body>
</html>
