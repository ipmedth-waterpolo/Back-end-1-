<!-- resources/views/emails/password_reset.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Wachtwoord Reset</title>
</head>
<body>
    <h1>Reset je wachtwoord</h1>
    <p>Hi {{ $user->name }},</p>
    <p>We hebben een verzoek ontvangen om je wachtwoord opnieuw in te stellen. Klik op de onderstaande link om je wachtwoord opnieuw in te stellen:</p>
    <a href="{{ route('password.reset', ['token' => $token]) }}">Reset Wachtwoord</a>
</body>
</html>
