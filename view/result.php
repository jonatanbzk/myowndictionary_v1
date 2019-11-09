<div id="responseId" style="display: block">
<?php
 global $evaluationNote;
 global $comment;
if (isset ($evaluationNote)) {
echo $evaluationNote;
}
if (isset ($comment)) {
echo I($comment) . "<br>" ;
}?>
<button type="button" name="button" id="show_result_button"
        onclick="toggleForm('response_div', 'show_result_button')">
        <?php echo I('result_detail');?>
</button>
</div>
<div id="response_div" style="display: none">
<p><?php echo I('result_good');?></p>
<?php
if (!empty($_SESSION['resultArray']['goodwords'])
   and !empty($_SESSION['resultArray']['goodtranslations'])) {
  $goodResponseLength = count($_SESSION['resultArray']['goodwords']);
  for ($i=0; $i<$goodResponseLength; $i++) {
    echo ucfirst($_SESSION['resultArray']['goodwords'][$i]) . "=>" .
    ucfirst($_SESSION['resultArray']['goodtranslations'][$i]) . "<br>";
  }
}
?>
<p><?php echo I('result_wrong');?></p>
<?php
if (isset($_SESSION['resultArray'], $_SESSION['testLength'])) {
  $badResponseLength = count($_SESSION['resultArray']['badwords']);
  for ($i=0; $i<$badResponseLength; $i++) {
    echo ucfirst($_SESSION['resultArray']['badwords'][$i]) . " ≠ " .
    ucfirst($_SESSION['resultArray']['badtranslations'][$i]) . '   ' .
    I('result_good_answer') .
    ucfirst($_SESSION['resultArray']['response'][$i]) . "<br>";
  }
}
?>
<form class="" action="index.php?action=closeTest" method="post">
<input type="submit" name="" value=<?php echo I('result_close');?>>
</form>
</div>
