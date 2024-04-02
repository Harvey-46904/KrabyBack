<?php
namespace App\Services;
use App\Traits\ConsumesExternalServices;


class CobruServices{
    use ConsumesExternalServices;
    protected $baseUri;
    protected $cobru_token;
    protected $refresh;
    protected $xapikey;

    public function __construct(){
        $this->baseUri=config("services.cobru.base_uri");
        $this->cobru_token=config("services.cobru.cobru_token");
        $this->refresh=config("services.cobru.refresh");
        $this->xapikey=config("services.cobru.xapikey");
    }

   public function resolveAuthorization(&$queryParams, &$formParams,&$headers){
    //$headers["Authorization"] = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0b2tlbl90eXBlIjoiYWNjZXNzIiwiZXhwIjoxNzAzODY0NTI2LCJqdGkiOiJmNjVhNzc2NTZlM2M0ZTJlYWMyODkxOTljYmI4N2JiNCIsInVzZXJfaWQiOjI3OTE5fQ.lizGs4nBjCqlSpJdvel6GVGXFJIBZYkwXTHe4XRIeJY";
   }
   public function resolverAccesoToken(){
    $refrescado=$this->refresh;
    $keysapi= $this->xapikey;

    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', 'https://dev.cobru.co/token/refresh/', [
          'body' => '{
          "refresh": "'.$refrescado.'"
        }',
          'headers' => [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'x-api-key' =>  "'.$keysapi.'",
          ],
        ]);
        $data = json_decode($response->getBody(), true);

    // Acceder al valor de 'access'
    $accessToken = $data['access'];
    return "Bearer ".$accessToken;
   }


   public function crear_cobru($valor){
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', $this->baseUri.'/cobru/', [
        'body' => '{
        "amount":"'.$valor.'",
        "platform": "API",
        "description": "Pagos Kraby",
        "expiration_days": 1,
        "payment_method_enabled": "{\\"NEQUI\\":true,\\"pse\\":true,\\"efecty\\":true,\\"credit_card\\": true}"
      }',
        'headers' => [
          'Accept' => 'application/json',
          'Authorization' => $this->resolverAccesoToken(),
          'Content-Type' => 'application/json',
          'x-api-key' => $this->xapikey,
        ],
      ]);
      $responseBody = $response->getBody();
      $data = json_decode($responseBody, true);
      return $data;
   }
public function push_nequi($uri){
  $client = new \GuzzleHttp\Client();
  $response = $client->request('POST', $this->baseUri.'/'.$uri, [
    'body' => '{
    "name": "Harvey Riascos",
    "payment": "NEQUI",
    "cc": "1085330718",
    "email": "harveympv@hotmail.com",
    "phone": "3226755570",
    "document_type": "CC",
    "phone_nequi": "3226755570",
    "push": true
    
  }',
    'headers' => [
      'Accept' => 'application/json',
      'Authorization' => $this->resolverAccesoToken(),
      'Content-Type' => 'application/json',
      'x-api-key' => $this->xapikey,
    ],
  ]);
  echo $response->getBody();



}
public function detalle_pago($uri){
  $client = new \GuzzleHttp\Client();
  $response = $client->request('GET', $this->baseUri.'/cobru_detail/'.$uri, [
    'headers' => [
      'Accept' => 'application/json',
      'Authorization' => $this->resolverAccesoToken(),
      'Content-Type' => 'application/json',
      'x-api-key' => $this->xapikey,
    ],
  ]);
  echo $response->getBody();

}



   public function decodeResponse($response){
    return json_decode($response);
}
}