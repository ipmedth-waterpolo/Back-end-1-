<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Oefening;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

    

    public function store(Request $request)
{
    

    $training = Training::create([
        'name' => $request->input('name'),
        'beschrijving' => $request->input('beschrijving'),
        'totale_duur' => $request->input('totale_duur'),
        'oefeningIDs' => json_encode(explode(',', $request->input('oefeningen'))), // Oefeningen-ID's als JSON opslaan
        'userID' => 1, // Hardcoded User ID
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
        'data' => $training,
    ], 200);
    }


    public function show($id)
{
    // Haal de specifieke training op
    $training = Training::findOrFail($id);

    // Decodeer de oefeningIDs uit de training
    $oefeningIDs = json_decode($training->oefeningIDs);

    // Haal de oefeningen op waarvan de IDs overeenkomen met de oefeningIDs
    $oefeningen = Oefening::whereIn('id', $oefeningIDs)->get();

    return response()->json([
        'success' => true,
        'data' => [
            'training' => $training,
            'oefeningen' => $oefeningen,
        ],
    ], 200);
}

}
