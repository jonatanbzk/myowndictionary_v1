<?php ob_start(); ?>

<form class="" action="../index.php?action=resetpassword" method="post">
  <label for="email">Adresse email</label> <br>
  <input type="email" name="email" placeholder="@" required> <br>
  <input type="submit" name="" value="Valider">
</form>


<script src="public/sign_up.js" charset="utf-8"></script>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
