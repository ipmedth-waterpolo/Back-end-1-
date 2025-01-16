@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h1>Welkom bij het Waterpolo Admin Paneel</h1>
    <h2>Selecteer een optie:</h2>
    <ul>
        <li><a href="{{ route('admin.users') }}">Gebruikersbeheer</a></li>
        <li><a href="{{ route('admin.trainings') }}">Trainingen beheren</a></li>
        <li><a href="{{ route('admin.exercises') }}">Oefeningen beheren</a></li>
    </ul>
    <!-- Logout Button -->
    <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 20px;">
        @csrf <!-- Include the CSRF token for security -->
        <button type="submit" style="background-color: #ff4d4d; color: white; padding: 10px 20px; border: none; cursor: pointer;">
            Logout
        </button>
    </form>
@endsection
