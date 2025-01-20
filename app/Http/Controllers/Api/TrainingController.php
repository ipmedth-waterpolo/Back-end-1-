<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Oefening;
use App\Models\Training;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'oefeningIDs' => $request->input('oefeningen'), // Oefeningen-ID's als JSON opslaan
            'userID' => Auth::id(),
            'enabled' => true, // Optioneel, standaard true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Training succesvol aangemaakt!',
            'data' => $training,
        ], 201);
    }

    public function index()
    {
        // Haal alle trainingen op
        $trainings = Training::all();
    
        // Voeg gemiddelde rating toe aan elke training
        foreach ($trainings as $training) {
            // Haal de ratings op voor deze training en bereken het gemiddelde
            $averageRating = Rating::where('trainingID', $training->id)->avg('ratingNumber');
            
            // Zet het gemiddelde rating als een nieuwe sleutel in de training
            $training->average_rating = $averageRating ? round($averageRating, 1) : null;  // Null if no rating
        }
    
        return response()->json([
            'success' => true,
            'data' => [
                'trainings' => $trainings,
            ],
        ], 200);
    }

    public function show($id)
    {
        // Haal de specifieke training op, inclusief de reviews
        $training = Training::with('reviews')->findOrFail($id);

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
        $training = Training::findOrFail($id);
        $training->update($request->all());
        return response()->json($training);
    }

    public function delete($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();
        return response()->json(['message' => 'Record deleted']);
    }

    public function addRating(Request $request, $trainingID)
    {
        // Valideer de input
        $validated = $request->validate([
            'ratingNumber' => 'required|integer|min:1|max:5',
        ]);
    
        // Controleer of de training bestaat
        $training = Training::findOrFail($trainingID);
    
        // Controleer of de gebruiker al een beoordeling heeft gegeven voor deze training
        $existingRating = Rating::where('trainingID', $trainingID)
                                ->where('userID', Auth::id())
                                ->first();
    
        if ($existingRating) {
            // Als de gebruiker al een rating heeft, werk de rating bij
            $existingRating->ratingNumber = $validated['ratingNumber'];
            $existingRating->save();
    
            return response()->json([
                'success' => true,
                'message' => 'Rating updated successfully!',
                'data' => $existingRating,
            ], 200);
        } else {
            // Anders sla een nieuwe rating op
            $rating = Rating::create([
                'ratingNumber' => $validated['ratingNumber'],
                'userID' => Auth::id(),
                'trainingID' => $trainingID,
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Rating added successfully!',
                'data' => $rating,
            ], 200);
        }
    }
}
