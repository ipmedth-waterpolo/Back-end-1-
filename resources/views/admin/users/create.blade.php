@extends('layouts.admin')

@section('title', 'Nieuwe Gebruiker Aanmaken') <!-- Set the page title -->

@section('content')
    <!-- Back Button -->
    <p>
        <button onclick="window.location='{{ url()->previous() }}'" class="btn">Terug</button>
    </p>

    <h1>Nieuwe Gebruiker Aanmaken</h1>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="error-messages">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- User Creation Form -->
    <form action="{{ route('admin.users.store') }}" method="POST" class="form">
        @csrf

        <label for="name">Naam:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        <br>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>
        <br>

        <label for="password_confirmation">Bevestig Wachtwoord:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        <br>

        <label for="role">Rol:</label>
        <select id="role" name="role" required>
            @foreach (\App\Models\User::ROLES as $role)
                @if ($restrictAdminRole && ($role === 'admin' || $role === 'onderhoud'))
                    <!-- If the user is 'onderhoud', skip 'admin' and 'onderhoud' -->
                    @continue
                @endif
                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                    {{ ucfirst($role) }}
                </option>
            @endforeach
        </select>
        <br>

        <button type="submit" class="btn">Gebruiker Aanmaken</button>
    </form>

    <p><a href="{{ route('admin.users') }}" class="btn">Terug naar Gebruikerslijst</a></p>
@endsection
