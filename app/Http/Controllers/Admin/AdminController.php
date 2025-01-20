<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Training;
use App\Models\Oefening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password; // For password reset functionality
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        // Check if the current user is 'onderhoud' and pass restriction flag to the view
        $restrictAdminRole = Auth::user()->role === 'onderhoud';
    
        return view('admin.users.create', compact('restrictAdminRole'));
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
    
        // Validatie
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
            'role' => 'sometimes|string',
        ]);
    
        // Controleer of de huidige gebruiker een 'onderhoud' is en rol-updates probeert te doen
        if (Auth::user()->role === 'onderhoud' && isset($validated['role'])) {
            if (in_array($validated['role'], ['admin', 'onderhoud'])) {
                return redirect()->back()->withErrors([
                    'role' => 'Je mag de rol van deze gebruiker niet instellen op admin of onderhoud.'
                ]);
            }
        }
    
        // Verwerk wachtwoord, indien aanwezig
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }
    
        // Update de gebruiker
        $user->update($validated);
    
        return redirect()->route('admin.users', $user->id)->with('success', 'Gebruiker succesvol bijgewerkt!');
    }    

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Gebruiker succesvol verwijderd!');
    }

    public function resetPassword(User $user)
{
    // Check if the logged-in user is an admin
    if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'onderhoud') {
        return redirect()->route('admin.users')->with('error', 'Je hebt geen toegang om het wachtwoord te resetten.');
    }

    // Send the password reset email
    Password::sendResetLink(['email' => $user->email]);

    // Return success message
    return redirect()->route('admin.users')->with('success', 'Er is een wachtwoord reset link naar de gebruiker gestuurd.');
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

        if (is_string($request->videos)) {
            $request->merge(['videos' => explode(', ', $request->videos)]);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'categorie' => 'required|array',
            'onderdeel' => 'required|array',
            'leeftijdsgroep' => 'required|array',
            'duur' => 'required|integer|min:1',
            'minimum_aantal_spelers' => 'required|integer|min:1',
            'benodigdheden' => 'nullable|string', // Input as string
            'water_nodig' => 'nullable|boolean',
            'omschrijving' => 'required|string',
            'variatie' => 'nullable|string',
            'source' => 'nullable|string',
            'afbeeldingen' => 'nullable|string',
            'videos' => 'nullable|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);
    
        // Split benodigdheden on commas, spaces, or both
        if (!empty($validated['benodigdheden'])) {
            $validated['benodigdheden'] = array_filter(array_map('trim', preg_split('/[\s,]+/', $validated['benodigdheden'])));
        }
    
        // Create the exercise
        Oefening::create($validated);
    
        // Redirect with success message
        return redirect()->route('admin.exercises')->with('success', 'Oefening gemaakt.');
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

    public function uploadExercises(Request $request)
{
    try {
        // Log dat het verzoek is aangekomen
        Log::info('JSON Upload gestart.');

        // Controleer of het bestand is geüpload
        if (!$request->hasFile('jsonFile')) {
            Log::error('Geen bestand ontvangen.');
            return redirect()->back()->withErrors('Geen bestand ontvangen.');
        }

        // Valideer het bestandstype
        $request->validate([
            'jsonFile' => 'required|file|mimes:json|max:2048',
        ]);

        // Log dat de validatie is geslaagd
        Log::info('Bestand validatie geslaagd.');

        // Decodeer de JSON-inhoud
        $file = $request->file('jsonFile');
        $jsonData = json_decode(file_get_contents($file->getRealPath()), true);

        // Log de JSON-data om te controleren of het correct is
        Log::info('JSON-data: ', $jsonData);

        // Controleer of de JSON correct is gedecodeerd
        if ($jsonData === null) {
            Log::error('Fout bij het decoderen van JSON.');
            return redirect()->back()->withErrors('JSON-bestand is niet correct geformatteerd.');
        }

        // Valideer de JSON-structuur
        $validator = Validator::make(['data' => $jsonData], [
            'data.*.name' => 'required|string|max:255',
            'data.*.categorie' => 'required|array',
            'data.*.onderdeel' => 'required|array',
            'data.*.leeftijdsgroep' => 'required|array',
            'data.*.duur' => 'required|integer|min:1',
            'data.*.minimum_aantal_spelers' => 'required|integer|min:1',
            'data.*.omschrijving' => 'required|string',
            'data.*.water_nodig' => 'nullable|boolean',
            'data.*.benodigdheden' => 'nullable|array',
            'data.*.variatie' => 'nullable|string',
            'data.*.source' => 'nullable|string',
            'data.*.afbeeldingen' => 'nullable|array',
            'data.*.videos' => 'nullable|array',
            'data.*.rating' => 'nullable|integer|min:1|max:5',
        ]);

        // Log validatiefouten indien aanwezig
        if ($validator->fails()) {
            Log::error('Validatiefouten: ', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Log dat validatie is geslaagd
        Log::info('JSON validatie geslaagd.');

        // Voeg de oefeningen toe aan de database
        foreach ($jsonData as $exerciseData) {
            Oefening::create($exerciseData);
        }

        Log::info('Oefeningen succesvol toegevoegd.');

        return redirect()->route('admin.exercises')->with('success', 'Oefeningen succesvol geüpload.');
    } catch (\Exception $e) {
        Log::error('Fout bij upload: ' . $e->getMessage());
        return redirect()->back()->withErrors('Er is een fout opgetreden: ' . $e->getMessage());
    }
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


    public function sendPasswordResetLink(Request $request)
    {
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return back()->withErrors(['email' => 'Er is geen account gekoppeld aan dit e-mailadres.']);
        }

        $token = Str::random(60); // Bijvoorbeeld een token genereren

        // Verstuur de wachtwoord-reset e-mail
        Mail::to($user->email)->send(new PasswordResetMail($user, $token));

        return back()->with('success', 'Wachtwoord reset link is verzonden.');
    }
}
