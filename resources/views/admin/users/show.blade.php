<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create User</title>
</head>
<body>
    <!-- Back Button -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'">Back</button>
    </p>

    <h1>Create New User</h1>

    <!-- Display Flash Messages -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- User Creation Form -->
    <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
    @csrf
    @if(isset($user))
        @method('PUT') <!-- This is for the update method -->
    @endif

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}" required>
    <br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}" required>
    <br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" {{ isset($user) ? '' : 'required' }}>
    <br>

    <label for="password_confirmation">Confirm Password:</label>
    <input type="password" id="password_confirmation" name="password_confirmation" {{ isset($user) ? '' : 'required' }}>
    <br>

    <label for="role">Role:</label>
    <select id="role" name="role" required>
        @foreach (\App\Models\User::ROLES as $role)
            <option value="{{ $role }}" {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>
    <br>

    <button type="submit">{{ isset($user) ? 'Update User' : 'Create User' }}</button>
</form>


    <p><a href="{{ route('admin.users') }}">Back to User List</a></p>
</body>
</html>
