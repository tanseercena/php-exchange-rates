<?php
namespace Tanseercena\PhpExchangeRates;

use Laravie\Parser\Xml\Reader;
use Laravie\Parser\Xml\Document;

class XmlParser {

  public static function parse($xml){
    $document = new Document();
    $stub = new Reader($document);
    $output = $stub->extract($xml);

    $parsed_data = $output->parse(
      [
        'rates' => ['uses' => 'item[targetCurrency>currency,exchangeRate>rate]'],
      ]
    );

    return $parsed_data;
  }
}
