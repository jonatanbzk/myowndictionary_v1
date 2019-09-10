 <?php
function postSignUp() {
  $username=$_POST['username'];
  $password=$_POST['password'];
  $email=$_POST['email'];
  $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $_SESSION['form_data'] = array (
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'email' => $_POST['email']);
  $db = dbConnect();
  $reqData = $db->query("SELECT username, email FROM users WHERE username='$username' OR email='$email'");
  $dataVerify = $reqData->fetch();
  if ($dataVerify['username'] == $username)
  {
    $_SESSION['error'] = "Pseudo déjà prit";
    header('Location: view/sign_up.php');
  }
  elseif ($dataVerify['email'] == $email)
  {
    $_SESSION['error'] = "Email déjà utilisé";
    header('Location: view/sign_up.php');
  }
  else
  {
    $reqData->closeCursor();
    $userCreate = $db->prepare('INSERT INTO users(username, password, email, registration_date) VALUES(:username, :password, :email, NOW())');
    $userCreate->execute(array(
    'username' => $username,
	  'password' => $pass_hache,
    'email' => $email,
    ));
    $_SESSION['error'] = "Votre compte a été créer";
    $_SESSION['form_data'] = array();
    header('Location: view/login_Page.php');
  }
}


function logIn() {
  $_SESSION['test_login_data'] = array (
    'username' => $_POST['username'],
    'password' => $_POST['password']);
  $username = $_POST['username'];
  $db = dbConnect();
  $log = $db->prepare('SELECT id_user, password FROM users WHERE username = :username');
  $log->execute(array(
  'username' => $username));
  $resultat = $log->fetch();

  //password verification
  if (!$resultat)
  {
    $_SESSION['error'] = 'Mauvais identifiant ou mot de passe !';
    header('Location: view/login_Page.php');
    exit();
  }
  else
  {
    if (password_verify($_POST['password'], $resultat['password']))
    {
      $_SESSION['test_login_data'] = array();
      $_SESSION['login_data'] = array (
      'username' => $_POST['username'],
      'id_user' => $resultat['id_user']);
      $log->closeCursor();
    }
    else
    {
      $_SESSION['error'] = 'Mauvais identifiant ou mot de passe !';
      header('Location: view/login_Page.php');
      exit();
    }
  }
}

// get language list
function getLanguages() {
   $_SESSION['languagesArray'] = array();
   $db = dbConnect();
   $languages = $db->query('SELECT language FROM languages ORDER BY language');
   while ($languages_data = $languages->fetch())
   {
     array_push($_SESSION['languagesArray'], $languages_data['language']);
   }
   $languages->closeCursor();
}

// get user dictionary tag
function getTag() {
  $_SESSION['tagArray'] = array();
  $db = dbConnect();
  $tag = $db->prepare('SELECT tag_name, language_1, language_2 FROM tags INNER JOIN users ON tags.id_user = users.id_user WHERE users.username = :username');
  $tag->execute(array(
  'username' => $_POST['username']));
  while ($tag_data = $tag->fetch())
  {
    array_push($_SESSION['tagArray'], $tag_data['tag_name']);
  }
   $tag->closeCursor();
}


function addUserDictionary() {
  // verify if the user have this dictionary
  $IfDictExist1 = $_POST['language1'] . '/' . $_POST['language2'];
  $IfDictExist2 = $_POST['language2'] . '/' . $_POST['language1'];
    if (in_array($IfDictExist1, $_SESSION['tagArray']) or in_array($IfDictExist2, $_SESSION['tagArray']))
    {
      throw new Exception('Vous avez déjà un dictionnaire avec ces langues');
    }
    else
    {
      $language1=$_POST['language1'];
      $language2=$_POST['language2'];
      $id_user=$_SESSION['login_data']['id_user'];
      $tabName = $language1 . '/' . $language2;
      $tabTest = array($language1, $language2);   // for verification
      sort($tabTest);
      $tabName2 = $tabTest[0] . '/' . $tabTest[1];
      $db = dbConnect();
      $tabCreate = $db->prepare('INSERT INTO tags(tag_name, tag_name2, id_user, language_1, language_2, add_date) VALUES(:tag_name, :tag_name2, :id_user, :language_1, :language_2, NOW())');
      $tabCreate->execute(array(
        'tag_name' => $tabName,
        'tag_name2' => $tabName2,
        'id_user' => $id_user,
        'language_1' => $language1,
        'language_2' => $language2,
      ));
      // refresh tagArray on dictionaryPage.php when new dictionary is add
      $_SESSION['tagArray'] = array();
      $tag = $db->prepare('SELECT tag_name FROM tags INNER JOIN users ON tags.id_user = users.id_user WHERE users.username = :username');
      $tag->execute(array(
        'username' => $_SESSION['login_data']['username']));
      while ($tag_data = $tag->fetch())
      {
        array_push($_SESSION['tagArray'], $tag_data['tag_name']);
      }
      throw new Exception(' Votre dictionnaire ' . $tabName . ' a bien été crée');
    }
}


function changeTagChoice() {
  $db = dbConnect();
  $lang = $db->prepare('SELECT language_1, language_2 FROM tags WHERE tag_name = :tag_name');
  $lang->execute(array(
    'tag_name' => $_POST['tagName']));
  $langue = $lang->fetch();
  $_SESSION['personel_language_array'] = $langue;
  // empty array in words show dictionary
  $_SESSION['wordsListArray'] = array();
  $_SESSION['translationsListArray'] = array();
  }


function languageId($language) {
$languageArray = array('Polonais', 'Français', 'Anglais', 'Allemand', 'Italien', 'Russe', 'Portugais', 'Espagnol', 'Espéranto');
$key = array_search('$language', $languageArray);
$language_Id = $key + 1;
return $language_Id;
}


function addaword() {
  $id_language1 = languageId($_POST['language1']);
  $id_language2 = languageId($_POST['language2']);
  $word = $_POST['addWord1'];
  $translation = $_POST['addWord2'];
  $idUser = $_SESSION['login_data']['id_user'];
  $db = dbConnect();
  $reqData = $db->query("SELECT word, translation FROM words WHERE id_user = '$idUser' AND id_language_word = '$id_language1' AND id_language_translation = '$id_language2' AND word = '$word'");
  $dataVerify = $reqData->fetch();
  if (!empty($dataVerify))
  {
    throw new Exception('Vous avez déjà ce mot dans votre dictionnaire');
  }
  else
  {
    $word = $db->prepare('INSERT INTO words(word, translation, id_language_word, id_language_translation ,id_user,  add_date) VALUES(:word, :translation, :id_language_word, :id_language_translation, :id_user,  NOW())');
    $word->execute(array(
      'word' => $_POST['addWord1'],
      'translation' => $_POST['addWord2'],
      'id_language_word' => $id_language1,
      'id_language_translation' => $id_language2,
      'id_user' => $_SESSION['login_data']['id_user'],
      ));
  }
  throw new Exception('Votre mot a bien été ajouté');
  $reqData->closeCursor();
  $word->closeCursor();
}


function showWordList() {
  $language_one_id = languageId($_SESSION['personel_language_array'][0]);
  $language_two_id = languageId($_SESSION['personel_language_array'][1]);
  $db = dbConnect();
  $wd = $db->prepare('SELECT id_word, word, translation FROM words WHERE id_user = :id_user AND id_language_word = :id_language_word AND id_language_translation = :id_language_translation');
  $wd->execute(array(
    'id_user' => $_SESSION['login_data']['id_user'],
    'id_language_word' => $language_one_id,
    'id_language_translation' => $language_two_id,
    ));
    $_SESSION['wordsAndTranslationArray'] = array(
      'words' => array(), 'translations' => array(), 'ids' => array()
    );
    while ($wordsList = $wd->fetch())
    {
      array_push($_SESSION['wordsAndTranslationArray']['words'], $wordsList['word']);
      array_push($_SESSION['wordsAndTranslationArray']['translations'], $wordsList['translation']);
      array_push($_SESSION['wordsAndTranslationArray']['ids'], $wordsList['id_word']);
    }
  $wd->closeCursor();
}


function eraseAWord() {
  $idWord = $_POST['idWord'];
  if (!empty($idWord))
  {
    $db = dbConnect();
    $ew = $db->query("DELETE FROM words WHERE id_word = '$idWord'");
    $ew->closeCursor();
  }
}


function editAWord() {
  $idWord = $_POST['idWord'];
  $newWord = $_POST['newWord'];
  $newTranslation = $_POST['newTranslation'];
  if (!empty($idWord))
  {
    $db = dbConnect();
    $editw = $db->query("UPDATE words SET word = '$newWord', translation = '$newTranslation' WHERE id_word = '$idWord'");
    $editw->closeCursor();
  }
}


function startTest () {
  if (!empty($_POST['numberQuestion']) and $_POST['numberQuestion']>0)
  {
    $nbrQuestion = $_POST['numberQuestion'];
  } else
  {
    $nbrQuestion = 10;
  }
  $language = explode("/", $_POST['typeTest']);
  $db = dbConnect();
  $test = $db->prepare('SELECT word, translation FROM words WHERE id_user = :id_user AND id_language_word = :id_language_word AND id_language_translation = :id_language_translation ORDER BY RAND() LIMIT :limit');
  $test->execute(array(
    'id_user' => $_SESSION['login_data']['id_user'],
    'id_language_word' => languageId($_SESSION['personel_language_array'][0]),
    'id_language_translation' => languageId($_SESSION['personel_language_array'][1]),
    'limit' => $nbrQuestion,
  ));
  $_SESSION['testArray'] = array(
    'words' => array(), 'translations' => array()
  );
  while ($testList = $test->fetch())
  {
    array_push($_SESSION['testArray']['words'], $testList['word']);
    array_push($_SESSION['testArray']['translations'], $testList['translation']);
  }
$test->closeCursor();
  $_SESSION['testDirection'] = '';
  if ($_SESSION['personel_language_array'][0]==$language[0] and $_SESSION['personel_language_array'][1]==$language[1])
  {
    $_SESSION['testDirection'] = 0;
  }
  elseif ($_SESSION['personel_language_array'][1]==$language[0] and $_SESSION['personel_language_array'][0]==$language[1])
  {
    $_SESSION['testDirection'] = 1;
  }
  elseif ($_POST['typeTest'] == "random")
  {
    $_SESSION['testDirection'] = 2;
  }
}


function dbConnect() {
  $db = new PDO('mysql:host=localhost;dbname=dictionary;charset=utf8', 'root', '');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
  return $db;
}
