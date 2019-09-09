<?php
if (empty($_SESSION['login_data']['id_user']) AND empty($_SESSION['login_data']['username']))
{
    header('location:../index.php');
}
ob_start(); ?>

<script type="text/javascript">
var lengthWordList='<?php if (array_key_exists('wordsListArray', $_SESSION)):echo count($_SESSION['wordsListArray']);endif; ?>';
</script>
<script type="text/javascript" src="dictionaryPage.js"></script>

<form class="" id="colorform" action="index.html" method="post">
  <select class="" name="tagName" id="colorSelect" onchange='changeColor()'>
    <option value="">Choix thème</option>
<?php  $colorArray = array ("AquaMarine", "Beige", "BlanchedAlmond", "Brown", "CadetBlue", "CornflowerBlue", "Coral", "DarkCyan", "DarkGray", "DarkKhaki", "DarkSalmon", "LightBlue");
foreach ($colorArray as $color) {
  echo '<option value=' . $color . '>' . $color . '</option>';
}
?>
  </select>
</form>

<div id="hello">
  <p><?php echo 'Bonjour ' . $_SESSION['login_data']['username']; ?></p>
</div>

<div id="dictionary">
  <div id="currentDictionary">
    <p> Dictionnaire actuel :  <?php if (array_key_exists('personel_language_array', $_SESSION)):echo $_SESSION['personel_language_array'][0] . " / " . $_SESSION['personel_language_array'][1]; else: echo "aucun"; endif; ?></p>
  </div>
  <div id="dictionary_form">
    <p><button type="button" name="button" id="add_languages_button" style="display: block;" onclick="toggleForm('add_languages_form', 'add_languages_button')">Créer un dictionnaire</button></p>
    <!--  Create dictionary  -->
    <form class="" id="add_languages_form" action="index.php?action=addUserTab" method="post" style="display: none;">
      <select class="language_1" name="language1">
        <option value="select">Sélectionner la première langue</option>
        <?php
        foreach ($_SESSION['languagesArray'] as $key)
        {
          ?>
          <option value="<?php echo $key ?>"><?php echo $key ?></option>
          <?php
        } ?>
      </select> <br>
      <select class="language_2" name="language2">
        <option value="select">Sélectionner la seconde langue</option>
        <?php
        foreach ($_SESSION['languagesArray'] as $key)
        {
          ?>
          <option value="<?php echo $key ?>"><?php echo $key ?></option>
          <?php
        } ?>
      </select> <br>
      <input type="hidden" name="user_name" value="<?php echo $_SESSION['login_data']['username'] ?>" />  <br>
      <input type="submit" name=""></button> <button type="button" name="button" id="" onclick="toggleForm('add_languages_form', 'add_languages_button')">Annuler</button>
    </form>
    <!--  Choose dictionary  -->
    <form class="" action="index.php?action=changeTag" method="post">
      <select class="" name="tagName" onchange='this.form.submit()'>
        <option value="select">Choisir un dictionnaire</option>
        <?php
        foreach ($_SESSION['tagArray'] as $list)
        {
          ?>
          <option value="<?php echo $list ?>"><?php echo $list ?></option>
          <?php
        } ?>
      </select>
      <noscript><input type="submit" value="Submit"></noscript>
    </form>
  </div>
</div>

<div id="addWordDiv">
  <p><button type="button" name="button" id="show_add_words_button" style="display: block;" onclick="toggleForm('addWord', 'show_add_words_button')">Ajouter un mot </button></p>
  <form class="" id="addWord" action="index.php?action=addWord" method="post" style="display: none;">
    <label for="">En <?php if (array_key_exists('personel_language_array', $_SESSION)):echo $_SESSION['personel_language_array'][0];endif; ?></label> <input type="text" name="addWord1" value="">
    <label for="">La traduction en <?php if (array_key_exists('personel_language_array', $_SESSION)):echo $_SESSION['personel_language_array'][1];endif; ?></label> <input type="text" name="addWord2" value="">
    <input type="hidden" name="language1" value="<?php echo $_SESSION['personel_language_array'][0] ?>" />
    <input type="hidden" name="language2" value="<?php echo $_SESSION['personel_language_array'][1] ?>" /> <br>
    <input type="submit" name="" value="Valider">
    <button type="button" name="button" id="" onclick="toggleForm('addWord', 'show_add_words_button')">Annuler</button>
  </form>
</div>

<div id="viewDictionary">
  <button type="button" name="button" id="show_words_button" style="display: block;" onclick="toggleForm('show_words_form', 'show_words_button')">Consulter son dictionnaire</button>
  <form class="" id="show_words_form" action="index.php?action=showWordList" method="post" style="display: none;">
    <input type="submit" name="" value="Montrer tout mon dictionnaire">
    <button type="button" name="button" id="cancel_shows_words_button" onclick="toggleForm('show_words_form', 'show_words_button')">Annuler</button>
  </form>
  <table>
    <thead>
      <tr>
        <th colspan="2"><?php if (array_key_exists('personel_language_array', $_SESSION)):echo $_SESSION['personel_language_array'][0] . " / " . $_SESSION['personel_language_array'][1];endif;?></th> <th>modifier <br> supprimer</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (isset($_SESSION['wordsListArray']))
      {
        $length = count($_SESSION['wordsListArray']);
        for ($i = 0; $i < $length; $i++)
        {
          echo '<tr><td>' . htmlspecialchars($_SESSION['wordsListArray'][$i]) . '</td><td>' . htmlspecialchars($_SESSION['translationsListArray'][$i]) . '</td><td><input type="checkbox" id="checkboxId' . ($i+1) . '"/></td></tr>';
          echo '<tr class="trHide" id="trHide' . ($i+1) . '"><td><input type="text" placeholder=' . $_SESSION['personel_language_array'][0] . '></td><td><input type="text" name="other" placeholder=' . $_SESSION['personel_language_array'][1] . '></td><td><button type="submit">Edit</button><form method="post" action="index.php?action=eraseWord"><input type="hidden" name="idWord" value="' . $_SESSION['id_word'][$i] . '" /><button type="submit">Erase</button></form></td></tr>';
        }
      }
       ?>
    </tbody>
  </table>
</div>

<div id="test">
  <input type="button" name="" value="Faire un test">
</div>

<div id="deconnexion">
  <form class="" action="index.php?action=deco" method="post">
    <input type="submit" name="deco" value="Déconnexion">
  </form>
</div>

<?php if (isset($_SESSION['error'])): echo $_SESSION['error'];endif;
  $_SESSION['error'] = ""; ?>

<script src="public/dictionaryPage.js" charset="utf-8"></script>

<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>
