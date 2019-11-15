<!DOCTYPE html>
<html>
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-152618096-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', GoogleAnalytics);
</script>

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
