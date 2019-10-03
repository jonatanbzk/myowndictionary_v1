<?php
if (isset($_GET['locale'])) {
  $_SESSION['locale'] = $_GET['locale'];
}
if (!isset($_SESSION['locale'])) {
  $_SESSION['locale'] = 'fr_FR';
}

$loc = array();

require('language/fr_FR.php');
require('language/en_US.php');

function _($key) {
  global $loc;
  $lang = $_SESSION['locale'];
  $default = 'fr_FR';
  if (isset($loc[$lang][$key])) {
    echo $loc[$lang][$key];
  } else if (isset($loc[$default][$key])) {
    echo $loc[$default][$key];
  } else {
    echo $key;
  }
}
