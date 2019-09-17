<?php session_start();
      ob_start(); ?>

<h2>Se connecter</h2>

<form id="formLogin" action="../index.php?action=logIn" method="post">
  <label for="username"> Pseudo </label> <br> <input type="text" name="username" value="<?php if (array_key_exists('test_login_data', $_SESSION) && array_key_exists('username', $_SESSION['test_login_data'])):echo $_SESSION['test_login_data']['username'];endif; ?>" required> <br>
  <label for="password"> Mot de passe </label> <br> <input type="password" name="password" value="<?php if (array_key_exists('test_login_data', $_SESSION) && array_key_exists('password', $_SESSION['test_login_data'])):echo $_SESSION['test_login_data']['password'];endif; ?>" required> <br>
  <input type="submit" name="" value="Valider">
</form>

<?php if (isset($_SESSION['error'])): echo $_SESSION['error'];endif;
  $_SESSION['error'] = ""; ?>

<p>Pas encore de compte MyOwnDictionary ?  <a href="sign_up.php">Je m'inscris</a></p>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
