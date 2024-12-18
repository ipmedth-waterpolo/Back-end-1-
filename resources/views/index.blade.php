<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainings Overzicht</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1>Trainings Overzicht</h1>
        <div class="row">
            @foreach($training as $training)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $training->name }}</h5>
                            <p class="card-text"><strong>Beschrijving:</strong> {{ Str::limit($training->beschrijving, 50) }}</p>
                            <p><strong>Totale Duur:</strong> {{ $training->totale_duur }} minuten</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
