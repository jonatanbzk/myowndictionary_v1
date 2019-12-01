<?php
include_once 'ClassMultiplication.php';


class MathHalf {
  public function half($nbr) {
    $mult = new MathDouble;
    $x = $mult->double($nbr);
    return $x / 2;
  }
}
