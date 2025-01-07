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

        $oefeningIDs = $request->input('oefeningen')
            ? array_map('trim', explode(',', $request->input('oefeningen')))
            : []; // Maak een array van oefening-IDs

        $training = Training::create([
            'name' => $request->input('name'),
            'beschrijving' => $request->input('beschrijving'),
            'totale_duur' => $request->input('totale_duur'),
            'oefeningIDs' => json_encode($oefeningIDs), // Opslaan als JSON-string
            'userID' => auth()->id(),
            'enabled' => $request->input('enabled', true),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Training succesvol aangemaakt!',
            'data' => $training,
        ], 201);
    }

    public function index()
    {
        $trainings = Training::all();

        // Cast oefeningIDs naar array
        foreach ($trainings as $training) {
            $training->oefeningIDs = json_decode($training->oefeningIDs, true);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'training' => $trainings,
            ],
        ], 200);
    }

    public function show($id)
    {
        $training = Training::findOrFail($id);

        // Decodeer oefeningIDs naar een array
        $training->oefeningIDs = json_decode($training->oefeningIDs, true);

        // Haal de oefeningen op
        $oefeningen = $training->oefeningIDs 
            ? Oefening::whereIn('id', $training->oefeningIDs)->get()
            : [];

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

        if ($request->has('oefeningen')) {
            $oefeningIDs = array_map('trim', explode(',', $request->input('oefeningen')));
            $request->merge(['oefeningIDs' => json_encode($oefeningIDs)]);
        }

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
        $request->validate([
            'ratingNumber' => 'required|integer|min:1|max:5',
        ]);

        $training = Training::findOrFail($trainingID);

        $rating = Rating::create([
            'ratingNumber' => $request->input('ratingNumber'),
            'userID' => auth()->id(),
            'trainingID' => $trainingID,
        ]);

        return response()->json([
            'success' => true,
            'data' => $rating,
        ], 200);
    }
}
