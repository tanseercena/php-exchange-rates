<?php
namespace Tanseercena\PhpExchangeRates;

class ExchangeRates {

  private $base_currency = 'USD';

  public function __construct($base = 'USD'){
    $this->base_currency = $base;
  }

  public function latest($format = 'array'){
    $response = [
      'base' => $this->base_currency,
      'date' => date("Y-m-d")
    ];

    $api_url = "http://www.floatrates.com/daily/".strtolower($this->base_currency).".json";

    $latest_data = json_decode(Api::get($api_url),true);

    $rates = array_reduce($latest_data, function ($result, $item) {
        $result[$item['code']] = $item['rate'];
        return $result;
    }, array());

    $response['rates'] = $rates;

    if($format == 'json'){
      $response = json_encode($response);
    }

    return $response;
  }

  public function historic($date = '', $format = 'array'){
    if(empty($date))
      $date = date("Y-m-d");

    $response = [
      'base' => $this->base_currency,
      'date' => $date
    ];

    $api_url = "http://www.floatrates.com/historical-exchange-rates.html?currency_date=".$date."&base_currency_code=".$this->base_currency."&format_type=xml";

    $historic_data_xml = Api::get($api_url);

    $rates = XmlParser::parse($historic_data_xml);

    $rates = array_reduce($rates['rates'], function ($result, $item) {
        $result[$item['currency']] = $item['rate'];
        return $result;
    }, array());

    $response['rates'] = $rates;

    if($format == 'json'){
      $response = json_encode($response);
    }

    return $response;

  }

}
