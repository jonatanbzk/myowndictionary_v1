<div id="responseId" style="display: block;">
<?php
if (isset($_SESSION['evaluation']))
{
echo $_SESSION['evaluation']['note'] . "  ";
echo $_SESSION['evaluation']['comment'] . "<br>";
}
 ?>

<button type="button" name="button" id="show_result_button" onclick="toggleForm('response_div', 'show_result_button')">Voir mon résultat en détail</button>
</div>
<div id="response_div" style="display: none">
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
<form class="" action="index.php?action=closeTest" method="post">
<input type="submit" name="" value="Fermer le test">
</form>
</div>
