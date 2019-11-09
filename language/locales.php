<?php
if (isset($_GET['locale'])) {
  $_SESSION['locale'] = $_GET['locale'];
}
if (!isset($_SESSION['locale'])) {
  $_SESSION['locale'] = 'fr_FR';
}

$loc = array();

require('fr_FR.php');
require('en_US.php');

function I($key) {
  global $loc;
  $lang = $_SESSION['locale'];
  $default = 'fr_FR';
  if (isset($loc[$lang][$key])) {
    return $loc[$lang][$key];
  } else if (isset($loc[$default][$key])) {
    return $loc[$default][$key];
  } else {
    return $key;
  }
}
