<!-- resources/views/auth/passwords/reset.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Reset Wachtwoord</title>
</head>
<body>
    <h1>Reset je wachtwoord</h1>
    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">E-mailadres:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Nieuw Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="password_confirmation">Bevestig Wachtwoord:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>

        <button type="submit">Reset Wachtwoord</button>
    </form>
</body>
</html>
