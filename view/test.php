<form class="" id="testInProgress" action="index.html" method="post">
  <?php
  if (isset($_SESSION['testDirection']) and isset($_SESSION['testArray']) and isset($_SESSION['personel_language_array']))
  {
    $testLength = count($_SESSION['testArray']['words']);
      if ($_SESSION['testDirection']==0)
      {
        for ($i=0; $i < $testLength; $i++)
        {
          echo $_SESSION['testArray']['words'][$i] . '<input type="text" name="" value="" placeholder="La traduction en ' . $_SESSION['personel_language_array'][1] . '"> <br>';
        }
      }
      elseif ($_SESSION['testDirection']==1)
      {
        $randWord = array_rand($_SESSION['testArray']['words'], $testLength);
        $randTrans = array_rand($_SESSION['testArray']['translations'], $testLength);
        for ($i=0; $i < $testLength; $i++)
        {
          echo $_SESSION['testArray']['translations'][$i] . '<input type="text" name="" value="" placeholder="La traduction en ' . $_SESSION['personel_language_array'][0] . '"> <br>';
        }
      }
      elseif ($_SESSION['testDirection']==2)
      {

        echo "kaka";
      }

  }  ?>

  <button type="submit" name="button">Valider</button>
</form>
