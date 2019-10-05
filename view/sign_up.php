<?php ob_start(); ?>

<h2><?php echo I('sign_registration');?></h2>

<form id="formSignUp" action="../index.php?action=signUp" method="post">
  <label for="username"><?php echo I('login_username');?></label> <br>
  <input type="text" name="username" id="username" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('username', $_SESSION['form_data'])):echo $_SESSION['form_data']['username'];endif; ?>" required> <br>
  <label for="password"><?php echo I('login_password');?></label> <br>
  <input type="password" name="password" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('password', $_SESSION['form_data'])):echo $_SESSION['form_data']['password'];endif; ?>" required> <br>
  <label for="repeatpassword"><?php echo I('sign_confirm_password');?></label> <br>
  <input type="password" name="repeatpassword" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('password', $_SESSION['form_data'])):echo $_SESSION['form_data']['password'];endif; ?>" required> <br>
  <label for="email"><?php echo I('sign_email');?></label> <br>
  <input type="email" name="email" id="email" value="<?php if (array_key_exists('form_data', $_SESSION) && array_key_exists('email', $_SESSION['form_data'])):echo $_SESSION['form_data']['email'];endif; ?>" required> <br>
  <p id="validiteCourriel"></p>
  <input type="submit" name="" value=<?php echo I('login_submit');?>>
</form>

<?php echo $_SESSION['error'];
    $_SESSION['error'] = "";
?>

<p><?php echo I('sign_I_already_have_account');?></p>
<form action="index.php?action=haveAccountLink" method="post">
    <button type="submit" name="" value="" class="btn-link"><?php echo I('sign_login');?></button>
</form>


<script src="../public/sign_up.js" charset="utf-8"></script>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
