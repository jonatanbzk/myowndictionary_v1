<?php ob_start(); ?>

<form class="formLogin" action="../index.php?action=resetpassword" method="post">
  <label for="email"><?php echo I('sign_email');?></label> <br>
  <input class="formText" type="email" name="email" placeholder="@" required> <br>
  <input type="submit" class="formSubmit" value=<?php echo I('login_submit');?>>
</form>

<p><?php echo I('reset_email_back');?></p>
<form action="index.php?action=haveAccountLink" method="post">
    <button type="submit" name="" value="" class="btn-link">
      <?php echo I('sign_login');?>
    </button>
</form>

<script src="public/sign_up.js" charset="utf-8"></script>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
