<?php session_start();
      ob_start(); ?>

<h2>Inscription</h2>

<form class="" action="../index.php?action=signUp" method="post">
  <label for=""> Pseudo : </label>  <input type="text" name="username" id="username" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('username', $_SESSION['form_data'])):echo $_SESSION['form_data']['username'];endif; ?>" required> <br>
  <label for=""> Mot de passe : </label>  <input type="password" name="password" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('password', $_SESSION['form_data'])):echo $_SESSION['form_data']['password'];endif; ?>" required> <br>
  <label for=""> Confirmer votre mot de passe : </label>  <input type="password" name="repeatpassword" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('password', $_SESSION['form_data'])):echo $_SESSION['form_data']['password'];endif; ?>" required> <br>
  <label for="">Adresse e-mail : </label>  <input type="text" name="email" id="email" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('email', $_SESSION['form_data'])):echo $_SESSION['form_data']['email'];endif; ?>" required> <br>
  <p id="validiteCourriel"></p>
  <input type="submit" name="" value="Valider">
</form>

<?php echo $_SESSION['error'];
    $_SESSION['error'] = "";
?>

<p>J'ai déjà un compte MyOwnDictionary ...  <a href="../index.php">Je me connecte</a></p>

<script src="../public/sign_up.js" charset="utf-8"></script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
