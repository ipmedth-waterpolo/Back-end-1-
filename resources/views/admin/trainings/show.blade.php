<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Training Details</title>
</head>
<body>
    <h1>{{ $training->name }}</h1>
    <p>Description: {{ $training->beschrijving }}</p>

    <form action="{{ route('admin.trainings.update', $training->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value="{{ $training->name }}">
        
        <label for="beschrijving">Description</label>
        <textarea id="beschrijving" name="beschrijving">{{ $training->beschrijving }}</textarea>

        <button type="submit">Update</button>
    </form>

    <form action="{{ route('admin.trainings.delete', $training->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</body>
</html>
