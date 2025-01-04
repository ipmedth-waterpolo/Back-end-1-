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

    // Users Management
    public function users()
    {
        $users = User::all(); // Retrieve all users
        return view('admin.users', ['users' => $users]); // Pass data to the view
    }
    
    public function showUser($id)
    {
        $user = User::findOrFail($id); // Retrieve the user by ID or throw 404
        return view('admin.users.show', ['user' => $user]); // Pass data to the view
    }    

    public function createUser()
    {
        // Render the view for the "Create User" form
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $request->role ?? 'gast',
        ]);

        // Redirect back to the user list with success message
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
    
        // Update the user
        if (isset($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        }
    
        $user->update($validated);
    
        // Redirect back to the user details page with success message
        return redirect()->route('admin.users.show', $user->id)->with('success', 'Gebruiker succesvol bijgewerkt!');
    }
    

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        // Redirect back to the user list with success message
        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol verwijderd!');
    }
    

    //exercises mangement
    public function exercises()
    {
        $exercises = Oefening::all();
        return view('admin.exercises', ['exercises' => $exercises]);
    }

    public function showExercise($id)
    {
        $exercise = Oefening::findOrFail($id);
        $exercises = Oefening::all(); // Fetch all exercises to populate dynamic dropdowns
    
        return view('admin.exercises.show', [
            'exercise' => $exercise,
            'exercises' => $exercises
        ]);
    }

    public function createExercisePage()
    {
        return view('admin.exercises.create');
    }

    public function createExercise(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie' => 'required|array',
            'onderdeel' => 'required|array',
            'leeftijdsgroep' => 'required|array',
            'duur' => 'required|integer',
            'minimum_aantal_spelers' => 'required|integer',
            'benodigdheden' => 'required|array',
            'water_nodig' => 'required|boolean',
            'omschrijving' => 'required|string',
            'variatie' => 'nullable|string',
            'source' => 'nullable|string',
            'afbeeldingen' => 'nullable|array',
            'videos' => 'nullable|array',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $exercise = Oefening::create($validated); // Save the exercise

        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully created.');
    }

    public function updateExercise(Request $request, $id)
    {
        $oefening = Oefening::findOrFail($id);
        $oefening->update($request->all()); // Update the exercise

        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully updated.');
    }

    public function deleteExercise($id)
    {
        $exercise = Oefening::findOrFail($id);
        $exercise->delete();

        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully deleted.');
    }

    // Trainings Management
    public function trainings()
    {
        $trainings = Training::all();
        return response()->json($trainings);
    }

    public function showTraining($id)
    {
        $training = Training::findOrFail($id);
        $oefeningen = Oefening::whereIn('id', json_decode($training->oefeningIDs))->get();

        return response()->json([
            'training' => $training,
            'oefeningen' => $oefeningen,
        ]);
    }

    public function createTraining(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'totale_duur' => 'required|integer',
            'oefeningIDs' => 'required|array',
        ]);

        $training = Training::create([
            'name' => $validated['name'],
            'beschrijving' => $validated['beschrijving'],
            'totale_duur' => $validated['totale_duur'],
            'oefeningIDs' => json_encode($validated['oefeningIDs']),
            'userID' => Auth::id(),
            'enabled' => true,
        ]);

        return response()->json(['message' => 'Training succesvol aangemaakt', 'training' => $training]);
    }

    public function updateTraining(Request $request, $id)
    {
        $training = Training::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'beschrijving' => 'sometimes|string',
            'totale_duur' => 'sometimes|integer',
            'oefeningIDs' => 'sometimes|array',
        ]);

        $training->update($validated);
        return response()->json(['message' => 'Training succesvol bijgewerkt', 'training' => $training]);
    }

    public function deleteTraining($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return response()->json(['message' => 'Training succesvol verwijderd']);
    }
}
