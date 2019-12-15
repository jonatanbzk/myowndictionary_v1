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

 <link href="https://fonts.googleapis.com/css?family=Acme|Mali&display=swap" rel="stylesheet">



    <title>MyOwnDictionary</title>
    <link href="./public/style.css" rel="stylesheet" />
    <link href="./public/styleInput.css" rel="stylesheet" />
    <link href="./public/styleDiv.css" rel="stylesheet" />
    <link href="./public/styleSelect.css" rel="stylesheet" />
    <link href="./public/styleShowWordBox.css" rel="stylesheet" />
  </head>
  <body>
    <div class="langLink">
      <a id="leftLink" href="<?php $_SERVER['QUERY_STRING']?>?locale=fr_FR">
        Français</a>
      <a id="rightLink" href="<?php $_SERVER['QUERY_STRING']?>?locale=en_US">
        English</a>
    </div>
    <h1>MyOwnDictionary</h1>
    <?= $content ?>
  </body>
</html>
