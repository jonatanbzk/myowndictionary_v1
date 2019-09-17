<?php
//echo $_SESSION['point'] . "/" . $_SESSION['testLength'];
if (isset($_SESSION['evaluation']))
{
echo $_SESSION['evaluation']['note'] . "  ";
echo $_SESSION['evaluation']['comment'];
}
 ?>
<div id="responseId" style="display: block;">
<button type="button" name="button">Voir mon résultat en détail</button>
<p>Réponse(s) correcte(s):</p>
<?php
if (!empty($_SESSION['resultArray']['goodwords']) and !empty($_SESSION['resultArray']['goodtranslations']))
{
$goodResponseLength = count($_SESSION['resultArray']['goodwords']);
  for ($i=0; $i<$goodResponseLength; $i++)
  {
    echo ucfirst($_SESSION['resultArray']['goodwords'][$i]) . "=>" . ucfirst($_SESSION['resultArray']['goodtranslations'][$i]) . "<br>";
  }
}
?>
<p>Réponse(s) fausse(s):</p>
<?php
if (isset($_SESSION['resultArray'], $_SESSION['testLength']))
{
$badResponseLength = count($_SESSION['resultArray']['badwords']);
  for ($i=0; $i<$badResponseLength; $i++)
  {
    echo ucfirst($_SESSION['resultArray']['badwords'][$i]) . " ≠ " . ucfirst($_SESSION['resultArray']['badtranslations'][$i]) . " Bonne réponse : " . ucfirst($_SESSION['resultArray']['response'][$i]) . "<br>";
  }
}
?>
</div>
