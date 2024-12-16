<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oefeningen</title>
    <!-- Voeg hier Bootstrap CSS toe -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container my-4">
        <h1 class="mb-4">Oefeningen</h1>
        <div class="row">
            <?php if (isset($oefeningen) && count($oefeningen) > 0): ?>
                <?php foreach ($oefeningen as $oefening): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <!-- Afbeelding -->
                            <?php
                            // Ensure that we only decode if the field is a string
                            $afbeeldingen = is_string($oefening->afbeeldingen) ? json_decode($oefening->afbeeldingen, true) : $oefening->afbeeldingen;
                            $image_url = isset($afbeeldingen['url']) && filter_var($afbeeldingen['url'], FILTER_VALIDATE_URL)
                                ? $afbeeldingen['url']
                                : "https://via.placeholder.com/150?text=Geen+afbeelding";
                            ?>
                            <img src="<?= htmlspecialchars($image_url) ?>" class="card-img-top" alt="<?= htmlspecialchars($oefening->name) ?>">

                            <div class="card-body">
                                <!-- Naam en beschrijving -->
                                <h5 class="card-title"><?= htmlspecialchars($oefening->name) ?></h5>
                                <p class="card-text text-truncate">
                                    <?= htmlspecialchars($oefening->omschrijving ?? 'Geen beschrijving beschikbaar.') ?>
                                </p>
                            </div>
                            <div class="card-footer text-muted">
                                <!-- Extra informatie -->
                                <small>Leeftijdsgroep:
                                    <?php
                                    // Check if 'leeftijdsgroep' is already an array or needs decoding
                                    $leeftijdsgroep = is_array($oefening->leeftijdsgroep)
                                        ? $oefening->leeftijdsgroep
                                        : json_decode($oefening->leeftijdsgroep, true);
                                    echo htmlspecialchars(implode(', ', $leeftijdsgroep ?? []));
                                    ?>
                                </small><br>
                                <small>Duur: <?= htmlspecialchars($oefening->duur) ?> minuten</small>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <p class="text-center">Geen oefeningen gevonden.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Voeg hier Bootstrap JS toe -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
