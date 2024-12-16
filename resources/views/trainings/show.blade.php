<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $training->name }} - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">{{ $training->name }}</h1>

        <p><strong>Beschrijving:</strong> {{ $training->beschrijving }}</p>
        <p><strong>Totale Duur:</strong> {{ $training->totale_duur }} minuten</p>
        <p><strong>Geactiveerd:</strong> {{ $training->enabled ? 'Ja' : 'Nee' }}</p>
        <p><strong>Beoordeling:</strong> {{ $training->ratings ?? 'Nog niet beoordeeld' }}</p>

        <!-- Voeg hier andere velden toe die je wilt weergeven -->

        <a href="/trainings" class="btn btn-secondary">Terug naar de lijst</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
