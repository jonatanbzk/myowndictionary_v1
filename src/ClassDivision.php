<?php
include_once 'ClassMultiplication.php';
class MathHalf {
public function __construct() {
    $this->doubler = new MathDouble;
  }

  public function half($nbr) {
    $x = $this->doubler->double($nbr);
    return $x / 2;
  }
}
