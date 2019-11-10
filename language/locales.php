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
?>
<script type="text/javascript">
// pass language user choice to sign_up.js
var lang='<?php if (array_key_exists(
        'locale', $_SESSION)):echo $_SESSION['locale'];endif; ?>';
</script>
<script type="text/javascript" src="sign_up.js"></script>
