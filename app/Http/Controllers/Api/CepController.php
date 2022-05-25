<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class CepController extends Controller
{

    private function fetch(string $ceps)
    {
        $cepsCollection = collect(explode(',', $ceps));

        $responseCollection = collect();

        $cepsCollection->each(function ($item, $key) use ($responseCollection) {
            $response = Http::get("viacep.com.br/ws/$item/json/");
            $responseCollection->add(json_decode($response->body()));
        });

        return $responseCollection;
    }

    /*
        Quando consultado um CEP de formato inválido, por exemplo: "950100100" (9 dígitos), "95010A10" (alfanumérico), "95010 10" (espaço), o código de retorno da consulta será um 400 (Bad Request). Antes de acessar o webservice, valide o formato do CEP e certifique-se que o mesmo possua {8} dígitos. Exemplo de como validar o formato do CEP em javascript está disponível nos exemplos abaixo.
        Quando consultado um CEP de formato válido, porém inexistente, por exemplo: "99999999", o retorno conterá um valor de "erro" igual a "true". Isso significa que o CEP consultado não foi encontrado na base de dados. Veja como manipular este "erro" em javascript nos exemplos abaixo. 
    */
    public function index(string $ceps)
    {   
        $cepsCollection = $this->fetch($ceps);
        
        return response()->json($cepsCollection);
    }
}
