<?php
namespace Tanseercena\PhpExchangeRates;

use DateTime;
use DateInterval;
use DatePeriod;

class RangeIterator {

  private $start_date;

  private $end_date;

  public function __construct($start,$end){
    $this->start_date = $start;
    $this->end_date = $end;
  }

  public function getRange($exchange,$format){

    $begin = new DateTime($this->start_date);
    $end = new DateTime($this->end_date);
    $end = $end->modify('+1 day');

    $interval = DateInterval::createFromDateString('1 day');
    $period = new DatePeriod($begin, $interval, $end);

    foreach ($period as $dt) {
        $date = $dt->format("Y-m-d");
        yield $exchange->historic($date,$format);
    }

  }

}
