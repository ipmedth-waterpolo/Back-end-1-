<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oefening;
use App\Models\Training;
use App\Models\Rating;
use Illuminate\Http\Request;

class TrainingController extends Controller
{



    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'beschrijving' => 'nullable|string',
        'totale_duur' => 'required|integer',
        'oefeningen' => 'nullable|string', // Input komt binnen als 'oefeningen'
        'enabled' => 'nullable|boolean',
    ]);

    $training = Training::create([
        'name' => $request->input('name'),
        'beschrijving' => $request->input('beschrijving'),
        'totale_duur' => $request->input('totale_duur'),
        'oefeningIDs' => json_encode(explode(',', $request->input('oefeningen'))), // Oefeningen-ID's als JSON opslaan
        'userID' => auth()->id(), // Hardcoded User ID
        'enabled' => true, // Optioneel, standaard true
    ]);

    // Retourneer de aangemaakte training als JSON
    return response()->json([
        'success' => true,
        'message' => 'Training succesvol aangemaakt!',
        'data' => $training,
    ], 201);

    }

    public function index()
    {
    // Haal de eerste training op
    $training = Training::all();

    return response()->json([
        'success' => true,
        'data' => [
            'training' => $training,
        ],
    ], 200);
    }


    public function show($id)
{
    // Haal de specifieke training op
    $training = Training::findOrFail($id);

    // Probeer oefeningIDs om te zetten naar een array
    $oefeningIDs = $training->oefeningIDs;

    if (is_string($oefeningIDs)) {
        // Decodeer JSON en controleer op fouten
        $decoded = json_decode($oefeningIDs, true);
        
        if (json_last_error() === JSON_ERROR_NONE) {
            $oefeningIDs = $decoded;
        } else {
            // Als JSON-decoding mislukt, probeer handmatige parsing of gebruik een lege array
            $oefeningIDs = explode(',', trim($oefeningIDs, '[]'));
        }
    }

    // Zorg dat oefeningIDs altijd een array is
    $oefeningIDs = is_array($oefeningIDs) ? $oefeningIDs : [];

    // Haal de oefeningen op waarvan de IDs overeenkomen met oefeningIDs
    $oefeningen = Oefening::whereIn('id', $oefeningIDs)->get();

    // Retourneer de response
    return response()->json([
        'success' => true,
        'data' => [
            'training' => $training,
            'oefeningen' => $oefeningen,
        ],
    ], 200);
}


    public function update(Request $request, $id)
    {
        $Training = Training::findOrFail($id);
        $Training->update($request->all());
        return response()->json($Training);
    }

    public function delete($id)
    {
        $Training = Training::findOrFail($id);
        $Training->delete();
        return response()->json(['message' => 'Record deleted']);
    }

    public function addRating(Request $request, $trainingID)
{
    // Valideer de input
    $request->validate([
        'ratingNumber' => 'required|integer|min:1|max:5',
    ]);

    // Controleer of de training bestaat
    $training = Training::findOrFail($trainingID);


    // Sla de rating op
    $rating = Rating::create([
        'ratingNumber' => $request->input('ratingNumber'),
        'userID' => auth()->id(), // Huidige gebruiker
        'trainingID' => $trainingID,
    ]);


    return response()->json([
        'success' => true,
        'data' => $rating,
    ], 200);
}



}
