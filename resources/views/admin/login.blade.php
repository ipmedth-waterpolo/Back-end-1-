@extends('layouts.admin')

@section('title', 'Inloggen')

@section('content')
    <h1>Inloggen</h1>

    <form action="{{ url('/admin/login') }}" method="POST">
        @csrf
        <label for="email">E-mailadres:</label>
        <input type="email" name="email" placeholder="Voer uw e-mailadres in" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" name="password" placeholder="Voer uw wachtwoord in" required>

        <br>
        <button type="submit">Inloggen</button>
    </form>

    @if(session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif
@endsection
