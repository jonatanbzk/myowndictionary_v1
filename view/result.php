<div id="responseId" style="display: block">
<?php
 global $evaluationNote;
 global $comment;
 global $resultArray;
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
if (!empty($resultArray['goodwords'])
   and !empty($resultArray['goodtranslations'])) {
  $goodResponseLength = count($resultArray['goodwords']);
  for ($i=0; $i<$goodResponseLength; $i++) {
    echo ucfirst($resultArray['goodwords'][$i]) . "=>" .
    ucfirst($resultArray['goodtranslations'][$i]) . "<br>";
  }
}
?>
<p><?php echo I('result_wrong');?></p>
<?php
if (isset($resultArray)) {
  $badResponseLength = count($resultArray['badwords']);
  for ($i=0; $i<$badResponseLength; $i++) {
    echo ucfirst($resultArray['badwords'][$i]) . " ≠ " .
    ucfirst($resultArray['badtranslations'][$i]) . '   ' .
    I('result_good_answer') .
    ucfirst($resultArray['response'][$i]) . "<br>";
  }
}
?>
</div>
<form class="" action="index.php?action=closeTest" method="post">
<input type="submit" name="" value=<?php echo I('result_close');?>>
</form>
