<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Str;

class ViacepService {

    // Valida um cep por meio do formato
    public function validateCepFormat(string $cep) : bool {
        return preg_match('/^[0-9]{5,5}([- ]?[0-9]{3,3})?$/', $cep);
    }

    // Consulta um cep
    public function getLocation(string $cep) : array {
        $response = Http::get("http://viacep.com.br/ws/{$cep}/json/");
        
        // Necessário para o typehint funcionar
        return (is_null($response->json()) ? [] : $response->json());   
    }

    public function getMultipleLocation(string $ceps) : array {

        // Filtramos os ceps, mantendo apenas o válidos
        $cepsCollection = collect(explode(',', $ceps))->filter(function ($value, $key) {
            return $this->validateCepFormat($value);
        });

        $responseCollection = collect();
    
        // Consultamos a API, um por um, utilizando o método getLocation
        $cepsCollection->each(function ($item, $key) use ($responseCollection) {
            $responseCollection->add(($this->getLocation($item)));
        });      

        return $responseCollection->toArray();
    }
}