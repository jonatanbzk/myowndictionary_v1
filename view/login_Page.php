<?php  if(!isset($_SESSION))
    {
      session_start();
    }
      ob_start(); ?>

<h2><?echo I('login_login');?></h2>

<form id="formLogin" action="../index.php?action=logIn" method="post">
  <label for="username"> <?echo I('login_username');?> </label> <br> <input type="text" name="username" value="<?php if (array_key_exists('test_login_data', $_SESSION) && array_key_exists('username', $_SESSION['test_login_data'])):echo $_SESSION['test_login_data']['username'];endif; ?>" required> <br>
  <label for="password"> <?echo I('login_password');?> </label> <br> <input type="password" name="password" value="<?php if (array_key_exists('test_login_data', $_SESSION) && array_key_exists('password', $_SESSION['test_login_data'])):echo $_SESSION['test_login_data']['password'];endif; ?>" required> <br>
  <input type="submit" name="" value=<?php echo I('login_submit');?>>
</form>
<br>
<?php if (isset($_SESSION['error'])): echo $_SESSION['error'];endif;
  $_SESSION['error'] = ""; ?>

<br>
<form action="index.php?action=forgotPasswordLink" method="post">
    <button type="submit" name="" value="" class="btn-link"><?echo I('login_forgot_your_password');?></button>
</form>
<p><?echo I('login_not_registered_yet');?>
  <form action="index.php?action=signUpLink" method="post">
      <button type="submit" name="" value="" class="btn-link"><?echo I('login_register');?></button>
  </form>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
