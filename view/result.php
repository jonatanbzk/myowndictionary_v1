<?php
//echo $_SESSION['point'] . "/" . $_SESSION['testLength'];
if (isset($_SESSION['evaluation']))
{
echo $_SESSION['evaluation']['note'] . "  ";
echo $_SESSION['evaluation']['comment'];
}
 ?>
<div id="responseId" style="display: none;">
<button type="button" name="button">Voir mon résultat en détail</button>
<p>Réponse(s) correcte(s):</p>
<?php
if (isset($_SESSION['resultArray']['goodtranslations'], $_SESSION['resultArray']['badtranslations'], $_SESSION['testLength']))
{
  for ($i=0; $i<$_SESSION['testLength']; $i++)
  {
    echo ucfirst($_SESSION['resultArray']['goodwords'][$i]) . "=>" . ucfirst($_SESSION['resultArray']['goodtranslations'][$i]) . "<br>";
  }
}
?>
<p>Réponse(s) fausse(s):</p>
<?php
if (isset($_SESSION['resultArray'], $_SESSION['testLength']))
{
  for ($i=0; $i<$_SESSION['testLength']; $i++)
  {
    echo ucfirst($_SESSION['resultArray']['badwords'][$i]) . " ≠ " . ucfirst($_SESSION['resultArray']['badtranslations'][$i]) . " Bonne réponse : " . ucfirst($_SESSION['resultArray']['response'][$i]) . "<br>";
  }
}
?>
</div>
