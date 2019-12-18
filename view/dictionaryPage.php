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


<div id="hello">
  <h2><?php
  echo I('dictionary_hello') . '   ' . $_SESSION['login_data']['username']; ?>
  </h2>
</div>

<p id="errorMsg">
<?php if (isset($_SESSION['error'])): echo $_SESSION['error'];endif;
  $_SESSION['error'] = "";
  if (!empty($e)) {
    echo $e->getMessage();
  }
  ?>
</p>


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
    <p id="buttonAddDict">
      <button
        class="btnJob" type="button" name="button"
        id="add_languages_button" style="display: block;"
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
      <input class="btnSubCanc" type="submit" name="" value="<?php echo I('login_submit'); ?>"></>
      <button class="btnSubCanc" type="button" name="button"
         onclick="toggleForm('add_languages_form', 'add_languages_button')">
         <?php echo I('dictionary_cancel'); ?>
      </button>
    </form>
    <!--  Choose dictionary  -->
    <form action="index.php?action=changeTag" method="post">
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
  <button class="btnJob" type="button" name="button"
  id="show_words_button" style="display: block;"
    onclick="toggleForm('show_words_div', 'show_words_button')">
    <?php echo I('dictionary_open_dictionary');?>
  </button>
  <div id="show_words_div" style="display: none;">
    <button type="button" class="btnJob" id="hide_words_button"
      onclick="toggleForm('show_words_div', 'show_words_button')">
      <?php echo I('dictionary_close_dictionary');?>
    </button>
    <?php include("wordsTab.php");?>
  </div>

  <div id="addWordDiv" style="display:
    <?php if (array_key_exists('personel_language_array', $_SESSION)):
    echo "block"; else: echo "none"; endif; ?>">
    <button type="button" class="btnJob" name="button" id="show_add_words_button"
      style="display: block;"
      onclick="toggleForm('addWord', 'show_add_words_button')">
      <?php echo I('dictionary_add_word');?>
    </button>
    <form class="" id="addWord" action="index.php?action=addWord"
          method="post" style="display: none;">
      <div id="addW">
        <label for="addWord1">
        <?php echo I('dictionary_in');
        if (array_key_exists('personel_language_array', $_SESSION)):
        echo I(languageToId($_SESSION['personel_language_array'][0]));endif;?>
        </label>
        <input type="text" class="inputMainPage" id="addWord1"
        name="addWord1" value=""><br>
        <label for="addWord2">
        <?php echo I('dictionary_translation_in');
        if (array_key_exists('personel_language_array', $_SESSION)):
        echo I(languageToId($_SESSION['personel_language_array'][1]));endif;?>
        </label>
        <input id="addWordTwo" type="text" class="inputMainPage" name="addWord2" value="">
      </div>
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
      <input class="btnSubCanc" type="submit" name=""
      value="<?php echo I('login_submit');?>">
      <button class="btnSubCanc" type="button" name="button"
        onclick="toggleForm('addWord', 'show_add_words_button')">
        <?php echo I('dictionary_cancel');?>
      </button>
    </form>
  </div>
</div>

<div id="test" style="display:
<?php if (array_key_exists('personel_language_array', $_SESSION)):
echo "block"; else: echo "none"; endif; ?>">
  <input type="button" class="btnJob" name="button" id="show_test"
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
          I(languageToId($_SESSION["personel_language_array"][0]))
           . ' &#8594; ' .
          I(languageToId($_SESSION["personel_language_array"][1])) .
        '</option>
        <option value="' . $_SESSION["personel_language_array"][1] . '/' .
          $_SESSION["personel_language_array"][0] . '">' .
          I(languageToId($_SESSION["personel_language_array"][1]))
           . ' &#8594; ' .
          I(languageToId($_SESSION["personel_language_array"][0])) .
        '</option>
        <option value="random">' .
        I("dictionary_random") .
        '</option>' ;endif;?>
    </select>  <br>
    <label for="numberQuestion">
      <?php echo I('dictionary_number_quest');?>
    </label>
    <input type="text" id="testNbrQuestion" class="inputMainPage"
    name="numberQuestion" maxlength="100" placeholder=
    "<?php echo I('dictionary_default');?>: 10 questions"/>
    <br>
    <input class="btnSubCanc" type="submit" name="" value="Start">
    <button class="btnSubCanc" type="button" name="button" id="cancel_shows_test_button"
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

<div class="formLogin" id="deconnexion">
  <form action="index.php?action=deco" method="post">
    <input class="formSubmit" id="logOutButton" type="submit"
           name="deco" value="<?php echo I('dictionary_disconnect');?>">
  </form>
</div>
<script src="public/dictionaryPage.js" charset="utf-8"></script>
<?php $content = ob_get_clean();
 require('template.php'); ?>
