<table id="words_table">
  <thead>
    <tr>
      <?php if (array_key_exists('personel_language_array', $_SESSION))
      :echo '<th colspan="2">' .
      I(languageToId($_SESSION["personel_language_array"][0])) . ' / ' .
      I(languageToId($_SESSION["personel_language_array"][1])) .
      '</th><th>' . I("dictionary_edit") . '<br>' .
      I('dictionary_erase') . '</th>';endif?>
    </tr>
  </thead>
  <tbody>
    <?php
    if (isset($_SESSION['wordsAndTranslationArray']))
    {
      if (isset($_POST['page'])) {
        $page = $_POST['page'];
      } else {
        $page = 1;
      }
      $pageLow = $page * 10 - 10;
      $pageHigh = $page * 10;
      $length = count($_SESSION['wordsAndTranslationArray']['words']);
      for ($i = 0; $i < $length; $i++)
      {
        if ($i < $pageLow or $i >= $pageHigh) {
          $displayTR = 'style="display: none"';
        } else {
          $displayTR = '';
        }
        $x = ceil(($i + 1) / 10);
        $trClassName = "trWord" . $x;
        echo
        '<tr class="trWords ' . $trClassName . '" ';
        if (!empty($displayTR)) {
          echo $displayTR;
        }
        echo '>
            <td>'
            . htmlspecialchars(ucfirst(
            $_SESSION['wordsAndTranslationArray']['words'][$i])) .
          '</td>
          <td>'
            . htmlspecialchars(ucfirst(
            $_SESSION['wordsAndTranslationArray']['translations'][$i])) .
          '</td>
          <td>
            <input type="checkbox" id="checkboxId' . ($i+1) . '"/>
          </td>
        </tr>
        <tr class="trHide" id="trHide' . ($i+1) . '">
          <form method="post" action="index.php?action=editWord">
            <td>
              <input type="text" class="inputMainPage" name="newWord" placeholder=' .
                I(languageToId($_SESSION['personel_language_array'][0])) .
                '>
            </td>
            <td>
              <input type="text" class="inputMainPage" name="newTranslation"
                name="other" placeholder=' .
                I(languageToId($_SESSION['personel_language_array'][1])) .
                '>
            </td>
            <td>
              <input type="hidden" name="idWord" value="' .
                $_SESSION['wordsAndTranslationArray']['ids'][$i] .
                '">
              <button type="submit" class="btnSubCanc" id="updateWord">' . I('dictionary_edit') . '</button>
          </form>
          <form method="post" action="index.php?action=eraseWord">
            <input type="hidden" name="idWord" value="' .
              $_SESSION['wordsAndTranslationArray']['ids'][$i] . '" />
            <button type="submit" class="btnSubCanc">';
        echo I('dictionary_erase') . '</button></form></td></tr>';
      }
    }?>
  </tbody>
</table>
<div class="">
<?php
  if (isset($_SESSION['wordsAndTranslationArray'])) {
    $pageNumber = ceil(count($_SESSION['wordsAndTranslationArray']['words']) / 10);
  }
  if ($pageNumber > 1) {
    echo '<form action="index.php?action=changePageLink" method="post">Page ';
    for ($i=1; $i <= $pageNumber; $i++) {
    echo '<button type="submit" class="pageBtn" name="page" value="' . $i . '">'
     . $i . '</button> ';
    }
    echo '</form>';
  }
?>

</div>
