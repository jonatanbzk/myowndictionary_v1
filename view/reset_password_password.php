<?php ob_start(); ?>

<form class="" action="../index.php?action=newpasswordform" method="post">
  <label for="newpassword"><?echo I('reset_new_password');?></label> <br>
  <input type="password" name="newpassword" value="" required> <br>
  <label for="newpassword2"><?echo I('reset_repeat_password');?></label> <br>
  <input type="password" name="newpassword2" value="" required> <br>
  <input type="hidden" name="username" value="<?php echo $_GET['username'] ?>">
  <input type="hidden" name="code" value="<?php echo $_GET['code'] ?>">
  <input type="submit" name="" value=<?echo I('login_submit');?>>
</form>

<script src="public/sign_up.js" charset="utf-8"></script>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
