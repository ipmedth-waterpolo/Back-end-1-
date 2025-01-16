@extends('layouts.admin')

@section('title', 'Gebruikersoverzicht') <!-- Set the page title -->

@section('content')
    <!-- Back Button -->
    <p>
        <a href="{{ route('admin.dashboard') }}" class="btn">Terug</a>
    </p>

    <h1>Gebruikers</h1>
    <a href="{{ route('admin.users.create') }}" class="btn">+ Nieuwe Gebruiker Toevoegen</a>

    <!-- Display Flash Messages -->
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @elseif(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <!-- Users Table Container with Scroll -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naam</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><a href="{{ route('admin.users.show', $user->id) }}">{{ $user->name }}</a></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn">Bekijken</a> |

                            <!-- Only show 'Verwijderen' button if the current user is an admin -->
                            @if (auth()->user()->role === 'admin')
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn-delete" onclick="confirmDelete()">Verwijderen</button>
                                </form>
                            @endif

                            <!-- Password Reset Link-->
                            <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn">Stuur Wachtwoord Reset Link</button>
                            </form>                        
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function confirmDelete() {
            // Show confirmation popup before deleting
            if (confirm("Weet je zeker dat je deze gebruiker wilt verwijderen?")) {
                // Submit the form only if confirmed
                document.querySelector('form').submit();
            }
        }
    </script>
@endsection
