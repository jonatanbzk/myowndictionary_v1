<?php ob_start(); ?>

<h2><?php echo I('sign_registration');?></h2>

<form class="formLogin" id="formSignUp" action="../index.php?action=signUp" method="post">
  <label for="username"><?php echo I('login_username');?></label> <br>
  <input type="text" class="formText" name="username" id="username"
         value="<?php if (!empty($form_data)
         && array_key_exists('username', $form_data)):
         echo $form_data['username'];endif; ?>"
         required> <br>
  <label for="password"><?php echo I('login_password');?></label> <br>
  <input type="password" class="formText" name="password"
         value="<?php if (!empty($form_data)
         && array_key_exists('password', $form_data)):
         echo $form_data['password'];endif; ?>"
         required> <br>
  <label for="repeatpassword">
    <?php echo I('sign_confirm_password');?>
  </label> <br>
  <input type="password" class="formText" name="repeatpassword"
         value="<?php if (!empty($form_data)
         && array_key_exists('password', $form_data)):
         echo $form_data['password'];endif; ?>"
         required> <br>
  <label for="email"><?php echo I('sign_email');?></label> <br>
  <input type="email" class="formText" name="email" id="email"
         value="<?php if (!empty($form_data)
         && array_key_exists('email', $form_data)):
         echo $form_data['email'];endif; ?>"
         required> <br>
  <p id="validiteCourriel"></p>
  <input type="submit" class="formSubmit" value=<?php echo I('login_submit');?>>
</form>

<?php if (array_key_exists('error', $_SESSION)):
    echo $_SESSION['error'] . '<br>';
    $_SESSION['error'] = "";endif;
    if (array_key_exists('mail', $_SESSION)):echo $_SESSION['mail'];
    $_SESSION['error'] = "";endif;
?>

<p><?php echo I('sign_I_already_have_account');?></p>
<form action="index.php?action=haveAccountLink" method="post">
    <button type="submit" name="" value="" class="btn-link">
      <?php echo I('sign_login');?>
    </button>
</form>


<script src="../public/sign_up.js" charset="utf-8"></script>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
