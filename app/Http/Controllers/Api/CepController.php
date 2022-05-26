<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Services\ViacepService;

class CepController extends Controller
{
    public function index(string $ceps)
    {   
        $cepService = new ViacepService();

        return response()->json($cepService->getLocation($ceps));
    }
}
