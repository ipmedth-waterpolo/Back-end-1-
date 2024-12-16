<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1>Training: {{ $training->name }}</h1>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $training->name }}</h5>
                <p class="card-text">{{ $training->beschrijving }}</p>
                <p><strong>Totale Duur:</strong> {{ $training->totale_duur }} minuten</p>
                <p><strong>Ratings:</strong> {{ $training->ratings ?? 'Geen beoordeling' }}</p>
            </div>
        </div>

        <h3 class="mt-4">Oefeningen bij deze training:</h3>

        <div class="row">
            @foreach($oefeningen as $oefening)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $oefening->name }}</h5>
                            <p class="card-text"><strong>Duur:</strong> {{ $oefening->duur }} minuten</p>
                            <p class="card-text"><strong>Omschrijving:</strong> {{ $oefening->omschrijving }}</p>
                            <p><strong>Categorie:</strong> {{ implode(', ', json_decode($oefening->categorie)) }}</p>
                            <p><strong>Onderdeel:</strong> {{ implode(', ', json_decode($oefening->onderdeel)) }}</p>
                            <p><strong>Leeftijdsgroep:</strong> {{ implode(', ', json_decode($oefening->leeftijdsgroep)) }}</p>
                            <p><strong>Benodigdheden:</strong> {{ implode(', ', json_decode($oefening->benodigdheden)) }}</p>
                            <p><strong>Water Nodig:</strong> {{ $oefening->water_nodig ? 'Ja' : 'Nee' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
