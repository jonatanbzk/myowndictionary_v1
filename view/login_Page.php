<?php session_start();
      ob_start(); ?>

<h2><?_('login_login');?></h2>

<form id="formLogin" action="../index.php?action=logIn" method="post">
  <label for="username"> <?_('login_login');?> </label> <br> <input type="text" name="username" value="<?php if (array_key_exists('test_login_data', $_SESSION) && array_key_exists('username', $_SESSION['test_login_data'])):echo $_SESSION['test_login_data']['username'];endif; ?>" required> <br>
  <label for="password"> <?_('login_password');?> </label> <br> <input type="password" name="password" value="<?php if (array_key_exists('test_login_data', $_SESSION) && array_key_exists('password', $_SESSION['test_login_data'])):echo $_SESSION['test_login_data']['password'];endif; ?>" required> <br>
  <input type="submit" name="" value="Valider">
</form>
<br>
<?php if (isset($_SESSION['error'])): echo $_SESSION['error'];endif;
  $_SESSION['error'] = ""; ?>

<br>
<a href="reset_password_email.php">Mot de passe oublié ?</a>
<p><?_('login_not_registered_yet');?> <a href="sign_up.php"><?_('login_register');?></a></p>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
