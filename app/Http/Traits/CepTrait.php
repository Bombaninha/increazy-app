<?php 

namespace App\Http\Traits;

use Illuminate\Support\Facades\Http;

trait CepTrait {
    
    public function fetchData(string $ceps) 
    {
        $cepsCollection = collect(explode(',', $ceps));
        $responseCollection = collect();
    
        $cepsCollection->each(function ($item, $key) use ($responseCollection) {
            $response = Http::get("viacep.com.br/ws/$item/json/");
            $responseCollection->add(json_decode($response->body()));
        });      

        return $responseCollection;
    }

}