<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Oefening; // Replace with your model

class DataController extends Controller
{
    // Fetch requested Oefening
    public function index(Request $request)
    {
        // Query parameters to filter Oefening
        $query = Oefening::query();

        if ($request->has('field')) {
            $query->select($request->get('field')); // Select specific fields
        }

        if ($request->has('conditions')) {
            foreach ($request->get('conditions') as $column => $value) {
                $query->where($column, $value); // Apply conditions
            }
        }

        return response()->json($query->get());
    }

    // Fetch a specific record
    public function show($id)
    {
        $Oefening = Oefening::findOrFail($id);
        return response()->json($Oefening);
    }

    // Create a new record
    public function store(Request $request)
    {
        $Oefening = Oefening::create($request->all());
        return response()->json($Oefening, 201);
    }

    // Update an existing record
    public function update(Request $request, $id)
    {
        $Oefening = Oefening::findOrFail($id);
        $Oefening->update($request->all());
        return response()->json($Oefening);
    }

    // Delete a record
    public function destroy($id)
    {
        $Oefening = Oefening::findOrFail($id);
        $Oefening->delete();
        return response()->json(['message' => 'Record deleted']);
    }
}