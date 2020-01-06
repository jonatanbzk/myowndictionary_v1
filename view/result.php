<div id="responseId" style="display: block">
<p id="testResultComment">
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
</p>
<button type="button" name="button" class="btnJob" id="show_result_button"
        onclick="toggleForm('response_div', 'show_result_button')">
        <?php echo I('result_detail');?>
</button>
</div>
<div id="response_div" style="display: none">
<p id="resultGood"><?php echo I('result_good');?></p>
<?php
if (!empty($resultArray['goodwords'])
   and !empty($resultArray['goodtranslations'])) {
  $goodResponseLength = count($resultArray['goodwords']);
  for ($i=0; $i<$goodResponseLength; $i++) {
    echo '<span class="goodWordResult">' . ucfirst($resultArray['goodwords'][$i]) . "</span> &#8594; " .
    ucfirst($resultArray['goodtranslations'][$i]) . "<br>";
  }
}
?>
<p><?php echo I('result_wrong');?></p>
<?php
if (isset($resultArray)) {
  $badResponseLength = count($resultArray['badwords']);
  for ($i=0; $i<$badResponseLength; $i++) {
    echo '<span class="goodWordResult">' . ucfirst($resultArray['badwords'][$i]) . '</span> ≠ <span id="wrongRep">' .
    ucfirst($resultArray['badtranslations'][$i]) . '</span>  &#8594;  ' .
    I('result_good_answer') . ucfirst($resultArray['response'][$i]) . "<br>";
  }
}
?>
</div>
<form class="" action="index.php?action=closeTest" method="post">
<input type="submit" class="btnSubCanc" value=<?php echo I('result_close');?>>
</form>
