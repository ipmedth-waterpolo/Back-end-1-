<?php

namespace App\Http\Controllers;
use App\Models\Oefening;

use Illuminate\Http\Request;

class ophalenOefeningen extends Controller
{
    public function index()
{
    $oefeningen = Oefening::all(); // haalt data van alle oefeningen op uit de database.
    foreach ($oefeningen as $oefening) {
        $oefening->omschrijving = strip_tags($oefening->omschrijving); //haalt de divs weg bij de omschrijving.
    }
    return view('welcome', compact('oefeningen'));
}

}
