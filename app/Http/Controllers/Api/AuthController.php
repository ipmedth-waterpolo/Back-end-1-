<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    // Show the admin login form
    public function showAdminLoginForm()
    {
        return view('admin.login'); // Ensure that this view exists
    }

    // Admin login (auth for admin panel)
    public function adminLogin(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to find the user by email
        $user = User::where('email', $validated['email'])->first();

        // If the user doesn't exist or the password doesn't match, throw validation error
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Ongeldige inloggegevens.']
            ]);
        }

        // Check if the user has an 'admin' or 'onderhoud' role
        if (!in_array($user->role, ['admin', 'onderhoud'])) {
            throw ValidationException::withMessages([
                'role' => ['Geen toegang voor deze gebruiker.']
            ]);
        }

        // Log the user in
        Auth::login($user);

        // Create a new token for authentication
        $token = $user->createToken('admin_auth_token')->plainTextToken;

        // Store the token in the session (you can also store it in cookies or another storage)
        session(['admin_token' => $token]);

        // Redirect to the admin dashboard with success message
        return Redirect::route('admin.dashboard')->with('message', 'Inloggen succesvol.');
    }

    // Logout method
    public function logout(Request $request)
    {
        // Revoke all tokens for the authenticated user
        $request->user()->tokens()->delete();

        // Log out the user from the session
        Auth::logout();

        // Invalidate the session and regenerate CSRF token for security
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to the login page with a message
        return Redirect::route('admin.login')->with('message', 'U bent succesvol uitgelogd.');
    }

    // Register a new user
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'De naam is verplicht.',
            'email.required' => 'Het e-mailadres is verplicht.',
            'password.required' => 'Het wachtwoord is verplicht.',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'gast', // Default role
        ]);

        return response()->json([
            'user' => $user,
            'message' => 'Gebruiker succesvol geregistreerd.'
        ], 201);
    }

    // Login a user
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Ongeldige inloggegevens.']
            ]);
        }

        // Create a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'role' => $user->role,
            'message' => 'Inloggen succesvol.'
        ]);
    }

    // Get the currently authenticated user's info
    public function getUserInfo()
    {
        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'message' => 'Gebruiker informatie succesvol opgehaald.'
        ]);
    }

    // Get info of any user (Admins and Onderhoud roles only)
    public function getAnyUserInfo($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('view', $user); // Ensure authorized access (Policy or Gates)

        return response()->json([
            'user' => $user,
            'message' => 'Gebruiker informatie succesvol opgehaald.'
        ]);
    }

    // Update the authenticated user's info
    public function updateUser(Request $request)
    {
        // Get authenticated user
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if ($request->has('name')) {
            $user->name = $validated['name'];
        }
        if ($request->has('email')) {
            $user->email = $validated['email'];
        }
        if ($request->has('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Gebruiker succesvol bijgewerkt.'
        ]);
    }

    // Delete the authenticated user's account
    public function deleteUser()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();

        $user->delete();

        return response()->json([
            'message' => 'Gebruiker succesvol verwijderd.'
        ]);
    }

    // Update any user's info (Admins and Onderhoud roles only)
    public function updateAnyUser(Request $request, $id)
    {
        // Only Admins and Onderhoud can update other users
        $user = User::findOrFail($id);
        $this->authorize('update', $user); // Ensure authorized access (Policy or Gates)

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|string|min:8|confirmed',
            'role' => 'sometimes|string|max:255',
        ]);

        if ($request->has('name')) {
            $user->name = $validated['name'];
        }
        if ($request->has('email')) {
            $user->email = $validated['email'];
        }
        if ($request->has('password')) {
            $user->password = Hash::make($validated['password']);
        }
        if ($request->has('role')) {
            $user->role = $validated['role'];
        }

        $user->save();

        return response()->json([
            'user' => $user,
            'message' => 'Gebruiker succesvol bijgewerkt.'
        ]);
    }

    // Delete any user's account (Admins and Onderhoud roles only)
    public function deleteAnyUser($id)
    {
        // Only Admins and Onderhoud can delete other users
        $user = User::findOrFail($id);
        $this->authorize('delete', $user); // Ensure authorized access (Policy or Gates)

        $user->delete();

        return response()->json([
            'message' => 'Gebruiker succesvol verwijderd.'
        ]);
    }

    // Get all users' information (Admins and Onderhoud roles only)
    public function getAllUsersInfo()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
            'message' => 'Alle gebruikersinformatie succesvol opgehaald.'
        ]);
    }
}
