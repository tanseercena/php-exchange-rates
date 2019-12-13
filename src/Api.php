<?php
namespace Tanseercena\PhpExchangeRates;

class Api {

  public static function get($url){
    $client = new \GuzzleHttp\Client();

    $response = $client->request('GET',$url);
    if($response->getStatusCode() == 200) {
      return $response->getBody();
    }
    //throw exceptions
    // For now just return false
    return false;
  }
}
