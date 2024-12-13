<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oefening;

class DataController extends Controller
{
    // Fetch requested Oefening
    public function index(Request $request)
    {
        $query = Oefening::query();

        if ($request->has('field')) {
            $query->select($request->get('field'));
        }

        if ($request->has('conditions')) {
            foreach ($request->get('conditions') as $column => $value) {
                $query->where($column, $value);
            }
        }

        return response()->json($query->get());
    }

    // Fetch a specific record
    public function show($id)
    {
        $oefening = Oefening::findOrFail($id);
        return response()->json($oefening);
    }

    // Update an existing record
    public function update(Request $request, $id)
    {
        $oefening = Oefening::findOrFail($id);
        $oefening->update($request->all());
        return response()->json($oefening);
    }

    // Delete a record
    public function destroy($id)
    {
        $oefening = Oefening::findOrFail($id);
        $oefening->delete();
        return response()->json(['message' => 'Record deleted']);
    }

    // Store a new record
    public function store(Request $request)
    {
        $user = $request->user();

        if (!$user->hasRole(['trainer', 'onderhoud', 'admin'])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $oefening = Oefening::create($request->all());
        return response()->json($oefening, 201);
    }
}
