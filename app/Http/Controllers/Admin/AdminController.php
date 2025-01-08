<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Training;
use App\Models\Oefening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'duur' => 'required|integer|min:1',
            'minimum_aantal_spelers' => 'required|integer|min:1',
            'benodigdheden' => 'nullable|array',
            'water_nodig' => 'nullable|boolean',
            'omschrijving' => 'required|string',
            'variatie' => 'nullable|string',
            'source' => 'nullable|string',
            'afbeeldingen' => 'nullable|string',
            'videos' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
            'icon' => 'nullable|string',
            'icon_upload' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($request->hasFile('icon_upload')) {
            $iconPath = $request->file('icon_upload')->store('icons', 'public');
            $validated['icon'] = $iconPath;
        }
    
        Oefening::create($validated);
    
        return redirect()->route('admin.exercises')->with('success', 'Exercise successfully created.');
    }    

    public function updateExercise(Request $request, $id)
    {
        $exercise = Oefening::findOrFail($id);
    
        if (is_string($request->benodigdheden)) {
            $request->merge(['benodigdheden' => explode(', ', $request->benodigdheden)]);
        }
        if (is_string($request->videos)) {
            $request->merge(['videos' => explode(', ', $request->videos)]);
        }
    
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'categorie' => 'sometimes|array',
            'onderdeel' => 'sometimes|array',
            'leeftijdsgroep' => 'sometimes|array',
            'duur' => 'sometimes|integer',
            'minimum_aantal_spelers' => 'sometimes|integer',
            'benodigdheden' => 'sometimes|array',
            'water_nodig' => 'sometimes|boolean',
            'omschrijving' => 'sometimes|string',
            'variatie' => 'nullable|string',
            'source' => 'nullable|string',
            'afbeeldingen' => 'nullable|array',
            'videos' => 'sometimes|array',
            'rating' => 'nullable|integer|min:1|max:5',
            'icon' => 'nullable|string',
            'icon_upload' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
    
        if ($request->hasFile('icon_upload')) {
            $iconPath = $request->file('icon_upload')->store('icons', 'public');
            $validated['icon'] = $iconPath;
    
            // Optionally delete the old icon if it exists
            if ($exercise->icon && Storage::disk('public')->exists($exercise->icon)) {
                Storage::disk('public')->delete($exercise->icon);
            }
        }
    
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
        // Fetch the training along with the user who created it
        $training = Training::with('user')->findOrFail($id);
    
        // Check if 'oefeningIDs' is a string, and decode it if needed
        $oefeningIDs = is_string($training->oefeningIDs) ? json_decode($training->oefeningIDs) : $training->oefeningIDs;
    
        // Fetch exercises associated with this training
        $oefeningen = Oefening::whereIn('id', $oefeningIDs)->get();
    
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

        // Ensure 'enabled' is either true or false.
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'beschrijving' => 'required|string',
            'totale_duur' => 'required|integer|min:0',
            'enabled' => 'nullable|boolean',  // 'nullable' allows the field to be null, 'boolean' ensures it's true or false
            'ratings' => 'nullable|numeric|min:0|max:5',
            'oefeningIDs' => 'array|nullable',
            'oefeningIDs.*' => 'exists:oefening,id',
        ]);

        // If 'enabled' is not set, set it to false
        if (!array_key_exists('enabled', $validated)) {
            $validated['enabled'] = false;
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
            'oefeningIDs' => $validated['oefeningIDs'],
        ]);
    
        // Sync the associated exercises (oefeningen)
        //if ($request->has('oefeningIDs')) {
        //    $training->oefening()->sync($validated['oefeningIDs']);
        //}
    
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
