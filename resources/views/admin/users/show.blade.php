@extends('layouts.admin')

@section('title', 'Gebruiker Bewerken')

@section('content')
    <p>
        <button onclick="window.location='{{ url()->previous() }}'" class="btn">Terug</button>
    </p>

    <h1>Gebruiker Bewerken</h1>

    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form">
        @csrf
        @method('PUT')

        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        <br>

        @if (!(($user->role === 'admin' || $user->role === 'onderhoud') && auth()->user()->role !== 'admin'))
    <label for="role">Rol:</label>
    <select id="role" name="role" required>
        @foreach (\App\Models\User::ROLES as $role)
            @if (auth()->user()->role === 'onderhoud' && ($role === 'admin' || $role === 'onderhoud'))
                <!-- Skip roles 'admin' and 'onderhoud' if current user is 'onderhoud' -->
                @continue
            @endif
            <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>
    <br>
@endif

        <button type="submit" class="btn">Gebruiker Bewerken</button>
    </form>

    <p><a href="{{ route('admin.users') }}" class="btn">Terug naar Gebruikerslijst</a></p>
@endsection
