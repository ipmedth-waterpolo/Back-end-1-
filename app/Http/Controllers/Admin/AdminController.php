<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Training;
use App\Models\Oefening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Users Management (no changes here, as it already follows the proper structure)
    public function users()
    {
        $users = User::all();
        return view('admin.users', ['users' => $users]);
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', ['user' => $user]);
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $request->role ?? 'gast',
        ]);

        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol aangemaakt!');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.show', $user->id)->with('success', 'Gebruiker succesvol bijgewerkt!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol verwijderd!');
    }

    // Exercises Management (no major changes here, already structured)
    public function exercises()
    {
        $exercises = Oefening::all();
        return view('admin.exercises', ['exercises' => $exercises]);
    }

    public function showExercise($id)
    {
        $exercise = Oefening::findOrFail($id);
        $exercises = Oefening::all();
        return view('admin.exercises.show', ['exercise' => $exercise, 'exercises' => $exercises]);
    }

    public function createExercise()
    {
        $exercises = Oefening::all();
        return view('admin.exercises.create', ['exercises' => $exercises]);
    }

    public function storeExercise(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie' => 'required|array',
            'onderdeel' => 'required|array',
            'leeftijdsgroep' => 'required|array',
            'duur' => 'required|integer|min:1', // Minimum 1 minute for duration
            'minimum_aantal_spelers' => 'required|integer|min:1', // Minimum 1 player
            'benodigdheden' => 'nullable|array', // Changed to nullable if it's optional
            'water_nodig' => 'nullable|boolean', // Changed to nullable
            'omschrijving' => 'required|string',
            'variatie' => 'nullable|string',
            'source' => 'nullable|string',
            'afbeeldingen' => 'nullable|string', // This could be a string (comma-separated file paths/URLs)
            'videos' => 'nullable|string', // This could be a string (comma-separated file paths/URLs)
            'rating' => 'nullable|integer|min:1|max:5',
        ]);
    
        // Create the exercise
        Oefening::create($validated);
    
        // Redirect with success message
        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully created.');
    }
    

    public function updateExercise(Request $request, $id)
    {
        $exercise = Oefening::findOrFail($id);
    
        // Ensure 'benodigdheden' and 'videos' are arrays before validation
        if (is_string($request->benodigdheden)) {
            $request->merge(['benodigdheden' => explode(', ', $request->benodigdheden)]);
        }
        if (is_string($request->videos)) {
            $request->merge(['videos' => explode(', ', $request->videos)]);
        }
    
        // Validate the incoming data
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'categorie' => 'sometimes|array',
            'onderdeel' => 'sometimes|array',
            'leeftijdsgroep' => 'sometimes|array',
            'duur' => 'sometimes|integer',
            'minimum_aantal_spelers' => 'sometimes|integer',
            'benodigdheden' => 'sometimes|array', // Now this will be treated as an array
            'water_nodig' => 'sometimes|boolean',
            'omschrijving' => 'sometimes|string',
            'variatie' => 'nullable|string',
            'source' => 'nullable|string',
            'afbeeldingen' => 'nullable|array',
            'videos' => 'sometimes|array', // Now this will be treated as an array
            'rating' => 'nullable|integer|min:1|max:5',
        ]);
    
        // Update the exercise
        $exercise->update($validated);
    
        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully updated.');
    }

    public function deleteExercise($id)
    {
        $exercise = Oefening::findOrFail($id);
        $exercise->delete();

        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully deleted.');
    }

    // Training Management
    public function trainings()
    {
        $trainings = Training::all();
        return view('admin.trainings', ['trainings' => $trainings]);
    }

    public function showTraining($id)
    {
        // Haal de training op inclusief de gebruiker die deze heeft aangemaakt
        $training = Training::with('user')->findOrFail($id);
    
        // Zorg ervoor dat oefeningIDs wordt omgezet naar een array
        // Dit splitst de string op komma's en maakt er een array van
        $oefeningIDs = explode(',', $training->oefeningIDs);
    
        // Fetch oefeningen die gekoppeld zijn aan deze training
        // We gebruiken whereIn om de oefeningen op te halen op basis van de array van oefeningIDs
        $oefeningen = Oefening::whereIn('id', $oefeningIDs)->get();
    
        // Geef de training en oefeningen door naar de view
        return view('admin.trainings.show', [
            'training' => $training,
            'oefeningen' => $oefeningen,
        ]);
    }    

    public function showTrainingEdit($id)
    {
        // Find the training by ID
        $training = Training::findOrFail($id);

        // Get all exercises for the dropdown
        $exercises = Oefening::all();

        return view('admin.trainings.edit', [
            'training' => $training,
            'exercises' => $exercises,
        ]);
    }

    public function updateTraining(Request $request, $id)
    {
        // Valideer de input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'totale_duur' => 'required|numeric',
            'enabled' => 'nullable|boolean', // 'nullable' allows the field to be null, 'boolean' ensures it's true or false
            'ratings' => 'nullable|numeric|min:0|max:5',
            'oefeningIDs' => 'array|nullable',
            'oefeningIDs.*' => 'exists:oefening,id',
        ]);
    
        // If 'enabled' is not set, set it to false
        if (!array_key_exists('enabled', $validated)) {
            $validated['enabled'] = false;
        }
    
        // Convert the 'oefeningIDs' array to a comma-separated string (if it's not null)
        if (isset($validated['oefeningIDs'])) {
            $validated['oefeningIDs'] = implode(',', $validated['oefeningIDs']);
        }
    
        // Find the training
        $training = Training::findOrFail($id);
    
        // Update the training details
        $training->update([
            'name' => $validated['name'],
            'beschrijving' => $validated['beschrijving'],
            'totale_duur' => $validated['totale_duur'],
            'enabled' => $validated['enabled'],
            'ratings' => $validated['ratings'],
            'oefeningIDs' => $validated['oefeningIDs'], // Store the comma-separated string in 'oefeningIDs'
        ]);
    
        // Redirect to the overview page (training list)
        return redirect()->route('admin.trainings')->with('success', 'Training updated successfully!');
    }
     

    public function createTraining()
    {
        // Get all exercises for the dropdown
        $exercises = Oefening::all();
        return view('admin.trainings.create', compact('exercises'));
    }    

    public function storeTraining(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'totale_duur' => 'required|integer|min:1',
            'oefeningIDs' => 'required|array',
            'enabled' => 'nullable|boolean',
            'ratings' => 'nullable|numeric|min:0|max:5',
        ]);
    
        Training::create([
            'name' => $validated['name'],
            'beschrijving' => $validated['beschrijving'],
            'totale_duur' => $validated['totale_duur'],
            'oefeningIDs' => json_encode($validated['oefeningIDs']),
            'userID' => Auth::id(),
            'enabled' => $request->has('enabled') ? $validated['enabled'] : false,
            'ratings' => $validated['ratings'] ?? null,
        ]);
    
        return redirect()->route('admin.trainings')->with('success', 'Training successfully created.');
    }    

    public function deleteTraining($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return redirect()->route('admin.trainings')->with('success', 'Training successfully deleted.');
    }
}
