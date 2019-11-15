<form id="testInProgress" action="index.php?action=test" method="post">
  <script type="text/javascript">
  window.addEventListener(
    'keydown',function(e){
      if(e.keyIdentifier=='U+000A'||e.keyIdentifier=='Enter'||e.keyCode==13)
      {if(e.target.nodeName=='INPUT'&&e.target.type=='text')
      {e.preventDefault();return false;}}},true);
  </script>
  <?php
global $testDirection;
// test direction = language1 => language2 or languague2 => language1 or Random
  if ((!empty($testDirection)) and isset($_SESSION['testArray'])
      and isset($_SESSION['personel_language_array'])) {
      $testLength = count($_SESSION['testArray']['words']);
      if ($testDirection==1) {
        for ($i=0; $i<$testLength; $i++) {
          if ($testLength==1) {
            echo '<div id="question' . ($i+1) . '" style="display: block;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['words'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][1])) .
            '" > <button type="submit" name="button">' . I('login_submit') .
            '</button></div>';
          }
          elseif ($i==0 and $testLength>1) {
            echo '<div id="question' . ($i+1) . '" style="display: block;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['words'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][1])) .
            '" > <button type="button" name="button"
            onclick="toggleForm(`question' . ($i+2) . '`, `question' .
            ($i+1) . '`)">' . I('login_submit') . '</button></div>';
          }
          elseif ($i>0 and $i<($testLength-1)) {
            echo '<div id="question' . ($i+1) . '" style="display: none;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['words'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][1])) .
            '" > <button type="button" name="button"
            onclick="toggleForm(`question' . ($i+2) . '`, `question' .
            ($i+1) . '`)">' . I('login_submit') . '</button></div>';
          }
          elseif ($i==($testLength-1)) {
            echo '<div id="question' . ($i+1) . '" style="display: none;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['words'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][1])) .
            '" > <button type="submit" name="button">' .
            I('login_submit') . '</button></div>';
          }
        }
      }
      elseif ($testDirection==2) {
        for ($i=0; $i<$testLength; $i++) {
          if ($testLength==1) {
            echo '<div id="question' . ($i+1) . '" style="display: block;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['words'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][1])) .
            '" > <button type="submit" name="button">' .
            I('login_submit') . '</button></div>';
          }
          elseif ($i==0 and $testLength>1) {
            echo '<div id="question' . ($i+1) . '" style="display: block;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['translations'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][0])) .
            '" > <button type="button" name="button"
            onclick="toggleForm(`question' . ($i+2) . '`, `question' .
            ($i+1) . '`)">' . I('login_submit') . '</button></div>';
          }
          elseif ($i>0 and $i<($testLength-1)) {
            echo '<div id="question' . ($i+1) . '" style="display: none;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['translations'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][0])) .
            '" > <button type="button" name="button"
            onclick="toggleForm(`question' . ($i+2) . '`, `question' .
            ($i+1) . '`)">' . I('login_submit') . '</button></div>';
          }
          elseif ($i == ($testLength-1)) {
            echo '<div id="question' . ($i+1) . '" style="display: none;">' .
            ($i+1) . "/" . $testLength . "  " .
            ucfirst($_SESSION['testArray']['translations'][$i]) .
            ' ==>   <input type="text" name="answer' . ($i+1) .
            '" value="" placeholder="' . I('test_translation') .
            I(languageToId($_SESSION['personel_language_array'][0])) .
            '" > <button type="submit" name="button">' .
            I('login_submit') . '</button></div>';
          }
        }
      }
      elseif ($testDirection==3) {
        for ($i=0; $i<$testLength ; $i++) {
          $rand = rand(0, 99);
          if ($rand % 2 == 0) {
            if ($testLength==1) {
              echo '<div id="question' . ($i+1) . '" style="display: block;">'
               . ($i+1) . "/" . $testLength . "  " .
              ucfirst($_SESSION['testArray']['words'][$i]) .
              ' ==>   <input type="text" name="answer' . ($i+1) .
              '" value="" placeholder="' . I('test_translation') .
              I(languageToId($_SESSION['personel_language_array'][1])) .
              '" > <button type="submit" name="button">' .
              I('login_submit') . '</button></div>';
            }
            elseif ($i==0 and $testLength>1) {
              echo '<div id="question' . ($i+1) . '" style="display: block;">'
               . ($i+1) . "/" . $testLength . "  " .
               ucfirst($_SESSION['testArray']['words'][$i]) .
               ' ==>   <input type="text" name="answer' . ($i+1) .
               '" value="" placeholder="' . I('test_translation') .
               I(languageToId($_SESSION['personel_language_array'][1])) .
               '" > <input type="hidden" name="indexTest' . ($i+1) .
               '" value="0"> <button type="button" name="button"
               onclick="toggleForm(`question' . ($i+2) . '`, `question' .
               ($i+1) . '`)">' . I("login_submit") . '</button></div>';
            }
            elseif ($i>0 and $i<($testLength-1)) {
              echo '<div id="question' . ($i+1) . '" style="display: none;">' .
               ($i+1) . "/" . $testLength . "  " .
               ucfirst($_SESSION['testArray']['words'][$i]) .
               ' ==>   <input type="text" name="answer' . ($i+1) .
               '" value="" placeholder="' . I('test_translation') .
               I(languageToId($_SESSION['personel_language_array'][1])) .
               '" > <input type="hidden" name="indexTest' . ($i+1) .
               '" value="0"> <button type="button" name="button"
               onclick="toggleForm(`question' . ($i+2) . '`, `question' .
               ($i+1) . '`)">' . I("login_submit") . '</button></div>';
            }
            elseif ($i==($testLength-1)) {
              echo '<div id="question' . ($i+1) . '" style="display: none;">' .
               ($i+1) . "/" . $testLength . "  " .
               ucfirst($_SESSION['testArray']['words'][$i]) .
               ' ==>   <input type="text" name="answer' . ($i+1) .
               '" value="" placeholder="' . I('test_translation') .
               I(languageToId($_SESSION['personel_language_array'][1])) .
               '" > <input type="hidden" name="indexTest' . ($i+1) .
               '" value="0"> <button type="submit" name="button">' .
               I("login_submit") . '</button></div>';
            }
          }
          elseif ($rand % 2 != 0) {
            if ($testLength==1) {
              echo '<div id="question' . ($i+1) . '" style="display: block;">'
               . ($i+1) . "/" . $testLength . "  " .
              ucfirst($_SESSION['testArray']['words'][$i]) .
              ' ==>   <input type="text" name="answer' . ($i+1) .
              '" value="" placeholder="' . I('test_translation') .
              I(languageToId($_SESSION['personel_language_array'][1])) .
              '" > <button type="submit" name="button">' .
              I('login_submit') . '</button></div>';
            }
            elseif ($i==0 and $testLength>1) {
              echo '<div id="question' . ($i+1) . '" style="display: block;">'
               . ($i+1) . "/" . $testLength . "  " .
               ucfirst($_SESSION['testArray']['translations'][$i]) .
               ' ==>   <input type="text" name="answer' . ($i+1) .
               '" value="" placeholder="' . I('test_translation') .
               I(languageToId($_SESSION['personel_language_array'][0])) .
               '" > <input type="hidden" name="indexTest' . ($i+1) .
               '" value="1"> <button type="button" name="button"
               onclick="toggleForm(`question' . ($i+2) .
               '`, `question' . ($i+1) . '`)">' .
               I("login_submit") . '</button></div>';
            }
            elseif ($i>0 and $i<($testLength-1)) {
              echo '<div id="question' . ($i+1) . '" style="display: none;">' .
               ($i+1) . "/" . $testLength . "  " .
               ucfirst($_SESSION['testArray']['translations'][$i]) .
               ' ==>   <input type="text" name="answer' . ($i+1) .
               '" value="" placeholder="' . I('test_translation') .
               I(languageToId($_SESSION['personel_language_array'][0])) .
               '" > <input type="hidden" name="indexTest' . ($i+1) .
               '" value="1"> <button type="button" name="button"
               onclick="toggleForm(`question' . ($i+2) .
               '`, `question' . ($i+1) . '`)">' .
               I("login_submit") . '</button></div>';
            }
            elseif ($i == ($testLength-1)) {
              echo '<div id="question' . ($i+1) . '" style="display: none;">' .
               ($i+1) . "/" . $testLength . "  " .
               ucfirst($_SESSION['testArray']['translations'][$i]) .
               ' ==>   <input type="text" name="answer' . ($i+1) .
               '" value="" placeholder="' . I('test_translation') .
               I(languageToId($_SESSION['personel_language_array'][0])) .
               '" > <input type="hidden" name="indexTest' . ($i+1) .
               '" value="1"> <button type="submit" name="button">' .
               I("login_submit") . '</button></div>';
            }
          }
      }
    }
    echo '<input type="hidden" name="testLength" value="' . $testLength . '">
    <br>
    <input type="hidden" name="testDirection" value="' . $testDirection . '">';
  } ?>
</form>
