<?php

namespace XAdmin\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function show($latitud, $longitud)
    {
        return view('maps.show', compact('latitud','longitud'));
    }
}
