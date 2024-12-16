<?php

namespace App\Http\Controllers;

use App\Models\Training;
use App\Models\Oefening;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

    

    public function store(Request $request)
    {

        dd($request->all());
        // Valideer de inkomende request
        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'beschrijving' => 'required|string',
        //     'totale_duur' => 'required|integer|min:1',
        //     'oefeningen' => 'required|array',
        //     'oefeningen.*' => 'exists:oefening,id',  // Controleer dat de oefeningen bestaan
        // ]);

        // // Maak een nieuwe training aan
        // $training = Training::create([
        //     'name' => $validated['name'],
        //     'beschrijving' => $validated['beschrijving'],
        //     'totale_duur' => $validated['totale_duur'],
        //     'oefening_ids' => json_encode($validated['oefeningen']), // Oefeningen-ID's opslaan als JSON
        // ]);

        // Terugsturen van succesbericht
        return response()->json([
            'message' => 'Training succesvol aangemaakt!',
            'training' => $training,
        ], 201);
    }

    public function index()
    {
    // Haal de eerste training op
    $training = Training::first();

    // Decodeer de oefeningIDs uit de training
    $oefeningIDs = json_decode($training->oefeningIDs);

    // Haal de oefeningen op waarvan de IDs overeenkomen met de oefeningIDs
    $oefeningen = Oefening::whereIn('id', $oefeningIDs)->get();

    // Stuur de training en oefeningen naar de view
    return view('index', compact('training', 'oefeningen'));
    }

    public function index2()
    {
        // Haal alle trainingen op
        $trainings = Training::all();
        return response()->json($trainings);
    }

    public function show($id)
    {
        // Haal een specifieke training op
        $training = Training::findOrFail($id);
        return response()->json($training);
    }
}
