<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeocodeController extends Controller
{
    public function geocode(Request $request): array
    {
        $url = "https://api.mapbox.com/search/geocode/v6/forward";

        $response = Http::get($url, [
            'q' => $request->input('address'),
            'access_token' => config('services.mapbox.key')
        ]);

        return $response->json();
    }
}
