<?php
if (empty($_SESSION['login_data']['id_user'])
AND empty($_SESSION['login_data']['username']))
{
    require('../index.php');
}
global $comment;
ob_start();
?>

<script type="text/javascript">
// pass length of words list to dictionaryPage.js
var lengthWordList='<?php if (array_key_exists(
  'wordsAndTranslationArray', $_SESSION))
  :echo count($_SESSION['wordsAndTranslationArray']['words']);endif; ?>';
</script>
<script type="text/javascript" src="dictionaryPage.js"></script>


<form class="" id="colorform" action="index.html" method="post">
  <select class="" name="tagName" id="colorSelect" onchange='changeColor()'>
    <option value=""><?php echo I('dictionary_theme_choice');?></option>
<?php  $colorArray = array (
  "AquaMarine", "Beige", "BlanchedAlmond", "Brown", "CadetBlue",
  "CornflowerBlue", "Coral", "DarkCyan", "DarkGray", "DarkKhaki",
  "DarkSalmon", "LightBlue");
foreach ($colorArray as $color) {
  echo '<option value=' . $color . '>' . $color . '</option>';
}
?>
  </select>
</form>

<div id="hello">
  <p><?php
  echo I('dictionary_hello') . '   ' . $_SESSION['login_data']['username']; ?>
  </p>
</div>

<div id="dictionary">
  <div id="currentDictionary">
    <p>
      <?php echo I('dictionary_current_dictionary');
     if (array_key_exists('personel_language_array', $_SESSION))
     :echo I(languageToId($_SESSION['personel_language_array'][0])) . "/" .
     I(languageToId($_SESSION['personel_language_array'][1]));
     else: echo I('dictionary_none'); endif;?>
    </p>
  </div>
  <div id="dictionary_form">
    <p>
      <button
        type="button" name="button" id="add_languages_button"
        style="display: block;"
        onclick="toggleForm('add_languages_form', 'add_languages_button')">
        <?php echo I('dictionary_create_dictionary');?>
      </button>
    </p>
    <!--  Create dictionary  -->
    <form
    id="add_languages_form"
    action="index.php?action=addUserTab"
    method="post" style="display: none;">
      <select class="language_1" name="language1">
        <option value="select">
          <?php echo I('dictionary_select_language_one');?>
        </option>
        <?php
	       $listLength = 9;
        for ($i=1; $i<=$listLength; $i++){?>
          <option value="<?php echo ($i); ?>">
            <?php echo (languageToId($i)); ?>
          </option>
          <?php
          } ?>
      </select> <br>
      <select class="language_2" name="language2">
        <option value="select">
          <?php echo I('dictionary_select_language_two');?>
        </option>
        <?php
        for ($i=1; $i<=$listLength; $i++){?>
          <option value="<?php echo ($i); ?>">
            <?php echo (languageToId($i)); ?>
          </option>
          <?php
          } ?>
      </select> <br>
      <input type="hidden" name="user_name"
         value="<?php echo $_SESSION['login_data']['username'] ?>" />  <br>
      <input type="submit" name="" value="<?php echo I('login_submit'); ?>"></>
      <button type="button" name="button"
         onclick="toggleForm('add_languages_form', 'add_languages_button')">
         <?php echo I('dictionary_cancel'); ?>
      </button>
    </form>
    <!--  Choose dictionary  -->
    <form class="" action="index.php?action=changeTag" method="post">
      <select class="" name="tagName" onchange='this.form.submit()'>
        <option value="select">
          <?php echo I('dictionary_select_dictionary');?>
        </option>
        <?php
        foreach ($_SESSION['tagArray'] as $list){
          $split = explode("/", $list);?>
        <option value="<?php echo $list; ?>">
          <?php echo languageToId($split[0]) . "/" . languageToId($split[1]);?>
        </option>
        <?php } ?>
      </select>
      <noscript>
        <input type="submit" value=<?php echo I('login_submit');?>>
      </noscript>
    </form>
  </div>
</div>

<div
  id="viewDictionary"
  style="display:
  <?php if (array_key_exists('personel_language_array', $_SESSION))
  : echo 'block'; else: echo 'none'; endif; ?>">
  <button
    type="button" name="button" id="show_words_button" style="display: block;"
    onclick="toggleForm('show_words_div', 'show_words_button')">
    <?php echo I('dictionary_open_dictionary');?>
  </button>
  <div id="show_words_div" style="display: none;">
    <button
      type="button" id="hide_words_button"
      onclick="toggleForm('show_words_div', 'show_words_button')">
      <?php echo I('dictionary_close_dictionary');?>
    </button>
    <table id="words_table">
      <thead>
        <tr>
          <?php if (array_key_exists('personel_language_array', $_SESSION))
          :echo '<th colspan="2">' .
          I(languageToId($_SESSION["personel_language_array"][0])) . ' / ' .
          I(languageToId($_SESSION["personel_language_array"][1])) .
          '</th><th>' . I("dictionary_edit") . '<br>' .
          I('dictionary_erase') . '</th>';endif?>
        </tr>
      </thead>
      <tbody>
        <?php
        if (isset($_SESSION['wordsAndTranslationArray']))
        {
          $length = count($_SESSION['wordsAndTranslationArray']['words']);
          for ($i = 0; $i < $length; $i++)
          {
            echo
            '<tr>
              <td>'
                . htmlspecialchars(ucfirst(
                $_SESSION['wordsAndTranslationArray']['words'][$i])) .
              '</td>
              <td>'
                . htmlspecialchars(ucfirst(
                $_SESSION['wordsAndTranslationArray']['translations'][$i])) .
              '</td>
              <td>
                <input type="checkbox" id="checkboxId' . ($i+1) . '"/>
              </td>
            </tr>
            <tr class="trHide" id="trHide' . ($i+1) . '">
              <form method="post" action="index.php?action=editWord">
                <td>
                  <input type="text" name="newWord" placeholder=' .
                    I(languageToId($_SESSION['personel_language_array'][0])) .
                    '>
                </td>
                <td>
                  <input type="text" name="newTranslation"
                    name="other" placeholder=' .
                    I(languageToId($_SESSION['personel_language_array'][1])) .
                    '>
                </td>
                <td>
                  <input type="hidden" name="idWord" value="' .
                    $_SESSION['wordsAndTranslationArray']['ids'][$i] .
                    '">
                  <button type="submit">' . I('dictionary_edit') . '</button>
              </form>
              <form method="post" action="index.php?action=eraseWord">
                <input type="hidden" name="idWord" value="' .
                  $_SESSION['wordsAndTranslationArray']['ids'][$i] . '" />
                <button type="submit">';
            echo I('dictionary_erase') . '</button></form></td></tr>';
          }
        }?>
      </tbody>
    </table>
  </div>

  <div id="addWordDiv" style="display:
    <?php if (array_key_exists('personel_language_array', $_SESSION)):
    echo "block"; else: echo "none"; endif; ?>">
    <button type="button" name="button" id="show_add_words_button"
      style="display: block;"
      onclick="toggleForm('addWord', 'show_add_words_button')">
      <?php echo I('dictionary_add_word');?>
    </button>
    <form class="" id="addWord" action="index.php?action=addWord"
          method="post" style="display: none;">
      <label for="addWord1">
        <?php echo I('dictionary_in');
        if (array_key_exists('personel_language_array', $_SESSION)):
        echo I(languageToId($_SESSION['personel_language_array'][0]));endif;?>
      </label>
      <input type="text" name="addWord1" value="">
      <label for="addWord2">
        <?php echo I('dictionary_translation_in');
        if (array_key_exists('personel_language_array', $_SESSION)):
        echo I(languageToId($_SESSION['personel_language_array'][1]));endif;?>
      </label>
      <input type="text" name="addWord2" value="">
      <input
        type="hidden" name="language1"
        value="<?php if (
          array_key_exists('personel_language_array', $_SESSION)):
          echo $_SESSION['personel_language_array'][0]; endif; ?>" />
      <input
        type="hidden" name="language2"
        value="<?php if (
          array_key_exists('personel_language_array', $_SESSION)):
          echo $_SESSION['personel_language_array'][1]; endif; ?>" /> <br>
      <input type="submit" name="" value="<?php echo I('login_submit');?>">
      <button type="button" name="button"
        onclick="toggleForm('addWord', 'show_add_words_button')">
        <?php echo I('dictionary_cancel');?>
      </button>
    </form>
  </div>
</div>

<div id="test" style="display:
<?php if (array_key_exists('personel_language_array', $_SESSION)):
echo "block"; else: echo "none"; endif; ?>">
  <input type="button" name="button" id="show_test"
         value="<?php echo I('dictionary_show_test');?>"
         style="display:
         <?php if (((array_key_exists('testArray', $_SESSION))
         and !empty($_SESSION['testArray']['words']))
         or (!empty($comment))):
         echo "none"; else: echo "block"; endif; ?>"
         onclick="toggleForm('show_test_form', 'show_test')">
  <form class="" action="index.php?action=lunchTest"
        method="post" id="show_test_form" style="display: none;">
    <select name="typeTest">
      <option value="select"><?php echo I('dictionary_test_type');?></option>
      <?php if (array_key_exists('personel_language_array', $_SESSION)): echo
        '<option value="' . $_SESSION["personel_language_array"][0] . '/' .
          $_SESSION["personel_language_array"][1] . '">' .
          I(languageToId($_SESSION["personel_language_array"][0])) . '=>' .
          I(languageToId($_SESSION["personel_language_array"][1])) .
        '</option>
        <option value="' . $_SESSION["personel_language_array"][1] . '/' .
          $_SESSION["personel_language_array"][0] . '">' .
          I(languageToId($_SESSION["personel_language_array"][1])) . '=>' .
          I(languageToId($_SESSION["personel_language_array"][0])) .
        '</option>
        <option value="random">' .
        I("dictionary_random") .
        '</option>' ;endif;?>
    </select>  <br>
    <label for="numberQuestion">
      <?php echo I('dictionary_number_quest');?>
    </label>
    <input type="text" name="numberQuestion" maxlength="100"
           placeholder="<?php echo I('dictionary_default');?>: 10 questions"/>
    <input type="submit" name="" value="Start">
    <button type="button" name="button" id="cancel_shows_test_button"
            onclick="toggleForm('show_test_form', 'show_test')">
            <?php echo I('dictionary_cancel');?>
    </button>
  </form>
  <div id="test_include"
       style="display:
       <?php if ((array_key_exists('testArray', $_SESSION))
       and !empty($_SESSION['testArray']['words'])):
       echo "block"; else: echo "none"; endif; ?>">
    <?php include("test.php");?>
  </div>
  <div id="result_include"
       style="display: <?php
       if (!empty($comment)):
       echo "block"; else: echo "none"; endif; ?>" >
    <?php include("result.php");?>
  </div>
</div>

<div id="deconnexion">
  <form class="" action="index.php?action=deco" method="post">
    <input id="logOutButton" type="submit"
           name="deco" value="<?php echo I('dictionary_disconnect');?>">
  </form>
</div>
<?php if (isset($_SESSION['error'])): echo $_SESSION['error'];endif;
  $_SESSION['error'] = ""; ?>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
