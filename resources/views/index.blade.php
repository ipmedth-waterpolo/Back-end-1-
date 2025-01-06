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
            @foreach($trainings as $training) <!-- Let op de meervoudige variabele -->
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $training->name }}</h5>
                            <p class="card-text"><strong>Beschrijving:</strong> {{ Str::limit($training->beschrijving, 50) }}</p>
                            <p><strong>Totale Duur:</strong> {{ $training->totale_duur }} minuten</p>
                            <p><strong>Gemiddelde Rating:</strong> 
                                
                            </p>

                            <!-- Formulier voor rating -->
                            <form action="{{ route('ratings.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="training_id" value="{{ $training->id }}">
                                <div class="mb-3">
                                    <label for="rating-{{ $training->id }}" class="form-label">Geef je rating (1-5):</label>
                                    <input type="number" class="form-control" id="rating-{{ $training->id }}" name="rating" min="1" max="5" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Rating toevoegen</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
