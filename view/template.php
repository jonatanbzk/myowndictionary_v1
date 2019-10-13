<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <a href="<?php $_SERVER['QUERY_STRING']?>?locale=fr_FR">FR</a>
    <a href="<?php $_SERVER['QUERY_STRING']?>?locale=en_US">US</a>
    <title>MyOwnDictionary</title>
    <link href="/public/style.css" rel="stylesheet" />
  </head>
  <body>
    <h1>MyOwnDictionary</h1>
    <?= $content ?>
  </body>
</html>
