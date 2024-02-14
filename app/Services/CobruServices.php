<?php
namespace App\Services;
use App\Traits\ConsumesExternalServices;


class CobruServices{
    use ConsumesExternalServices;
    protected $baseUri;
    protected $token;
    protected $refresh;

    public function __construct(){
        $this->baseUri=config("services.cobru.base_uri");
        $this->token=config("services.cobru.token");
        $this->refresh=config("services.cobru.refresh");
    }

   public function resolveAuthorization(&$queryParams, &$formParams,&$headers){
    //$headers["Authorization"] = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbl90eXBlIjoiYWNjZXNzIiwiZXhwIjoxNzAzODY0NTI2LCJqdGkiOiJmNjVhNzc2NTZlM2M0ZTJlYWMyODkxOTljYmI4N2JiNCIsInVzZXJfaWQiOjI3OTE5fQ.lizGs4nBjCqlSpJdvel6GVGXFJIBZYkwXTHe4XRIeJY";
   }
   public function resolverAccesoToken(){
    $refrescado=$this->refresh;
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://dev.cobru.co/token/refresh/', [
          'body' => '{
          "refresh": "'.$refrescado.'"
        }',
          'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'x-api-key' => '12212215',
          ],
        ]);
        $data = json_decode($response->getBody(), true);

    // Acceder al valor de 'access'
    $accessToken = $data['access'];
    return  $accessToken;
   }


   public function crear_cobru($valor){
    $client = new \GuzzleHttp\Client();

    $response = $client->request('POST', 'https://dev.cobru.co/cobru/', [
        'body' => '{
        "amount": 50000,
        "platform": "API",
        "description": "Venta de zapatos rojos",
        "expiration_days": 7,
        "payment_method_enabled": "{\\"NEQUI\\":true,\\"pse\\":true,\\"efecty\\":true,\\"credit_card\\": true}"
      }',
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => $this->resolverAccesoToken(),
          'Content-Type' => 'application/json',
          'x-api-key' => '12212215',
        ],
      ]);
      
    echo $response->getBody();
   }

   public function decodeResponse($response){
    return json_decode($response);
}
}