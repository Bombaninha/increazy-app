<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;

use App\Services\ViacepService;

class ViacepServiceTest extends TestCase
{
    public function test_if_viacep_api_is_working()
    {
        $cep = '95700-826';
        $response = Http::get("http://viacep.com.br/ws/$cep/json/");

        $this->assertSame(200, $response->status());
    }

    public function test_if_response_is_an_array()
    {
        $cep = '95700-826';
        $response = Http::get("http://viacep.com.br/ws/$cep/json/");

        $this->assertTrue(Arr::accessible($response->json()));
    }

    public function test_if_viacep_service_get_location_is_working()
    {
        $cep = '95700-826';

        $service = new ViacepService();
        $location = $service->getLocation($cep);

        $this->assertSame($cep, $location['cep']);
    }

    public function test_if_viacep_service_get_location_is_working_with_unkown_cep()
    {
        $cep = '99999999';

        $service = new ViacepService();
        $location = $service->getLocation($cep);

        $this->assertSame('true', $location['erro']);
    }

    public function test_if_viacep_service_get_location_doesnt_return_invalid_cep_with_size_greater_than_8_digits()
    {
        $cep = '950100100';

        $service = new ViacepService();
        $location = $service->getLocation($cep);

        $this->assertSame([], $location);
    }  
    
    public function test_if_viacep_service_get_location_doesnt_return_invalid_cep_with_alphanumeric_chars()
    {
        $cep = '95010A10';

        $service = new ViacepService();
        $location = $service->getLocation($cep);

        $this->assertSame([], $location);
    }  

    public function test_if_viacep_service_get_location_doesnt_return_invalid_cep_with_space()
    {
        $cep = '95010 10';

        $service = new ViacepService();
        $location = $service->getLocation($cep);

        $this->assertSame([], $location);
    }  

    public function test_if_viacep_service_get_location_has_all_the_keys()
    {
        $cep = '95700-826';

        $service = new ViacepService();
        $location = $service->getLocation($cep);

        $requiredKeys = array('cep', 'logradouro', 'complemento', 'bairro', 'localidade', 'uf', 'ibge', 'gia', 'ddd', 'siafi');

        $this->assertSame(count($requiredKeys), count(array_intersect_key(array_flip($requiredKeys), $location)));
    }

    public function test_if_viacep_service_get_multiple_location_returns_all_elements()
    {
        $ceps = '01001000,17560-246';

        $service = new ViacepService();
        $locations = $service->getMultipleLocation($ceps);

        $this->assertSame(2, count($locations));    
    }

    public function test_if_viacep_service_get_multiple_location_returns_right_elements()
    {
        $ceps = '01001000,17560-246';

        $service = new ViacepService();
        $locations = $service->getMultipleLocation($ceps);

        $this->assertTrue($locations[0]['cep'] == '01001-000' && $locations[1]['cep'] == '17560-246');   
    }
}
