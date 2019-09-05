<?php
function postSignUp()
{
  if (isset($_POST['username'], $_POST['password'], $_POST['email']))
  {
    $username=$_POST['username'];
    $password=$_POST['password'];
    $email=$_POST['email'];
    $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $_SESSION['form_data'] = array (
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'email' => $_POST['email']);
  } else
  {
    $_SESSION['error'] = "Veuiller compléter tout les champs";
    header('Location: view/sign_up.php');
  }

  $db = dbConnect();
  $reqData = $db->query("SELECT username, email FROM users WHERE username='$username' OR email='$email'");
//if ($dataVerify = $reqData->fetch())
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

function logIn () {
if (isset($_POST['username'], $_POST['password']))
{
    $_SESSION['test_login_data'] = array (
      'username' => $_POST['username'],
      'password' => $_POST['password']);

    $username = $_POST['username'];
    $db = dbConnect();
    $log = $db->prepare('SELECT id_user, password FROM users WHERE username = :username');
    $log->execute(array(
    'username' => $username));
    $resultat = $log->fetch();
} else {
  $_SESSION['error'] = "Veuiller compléter tout les champs";
  header('Location: view/login_Page.php');
  exit();
}

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

function getLanguages()
{
   $_SESSION['languagesArray'] = array();
   $db = dbConnect();
   $languages = $db->query('SELECT language FROM languages ORDER BY language');
   while ($languages_data = $languages->fetch())
   {
     array_push($_SESSION['languagesArray'], $languages_data['language']);
   }
   $languages->closeCursor();
}

function getTag()
{
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


function addUserDictionary()
{
  // creation de deux variable pour verif si l'user n'a pas deja ce dico
  $IfDictExist1 = $_POST['language1'] . '/' . $_POST['language2'];
  $IfDictExist2 = $_POST['language2'] . '/' . $_POST['language1'];


  try {
  if (empty($_POST['language1'] or empty($_POST['language2'])))
  {
    throw new Exception('Veuillez choisir deux langues');
  }
  elseif ($_POST['language1'] == "select" or $_POST['language2'] == "select")
  {
    throw new Exception('Veuillez choisir deux langues');
  }
  elseif ($_POST['language1'] == $_POST['language2'])
  {
    throw new Exception('Veuillez choisir deux langues différentes');
  }
  elseif (in_array($IfDictExist1, $_SESSION['tagArray']) or in_array($IfDictExist2, $_SESSION['tagArray']))
  {
    throw new Exception('Vous avez déjà un dictionnaire avec ces langues');
  }

  else {
  $language1=$_POST['language1'];
  $language2=$_POST['language2'];
  $id_user=$_SESSION['login_data']['id_user'];
  $tabName = $language1 . '/' . $language2;
//  $tabName2 = $language2 . '/' . $language1;

  //prepare $tabName2
  $tabTest = array($language1, $language2);
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
// refresh  tagArray on dictionaryPage.php
  $_SESSION['tagArray'] = array();
  $tag = $db->prepare('SELECT tag_name FROM tags INNER JOIN users ON tags.id_user = users.id_user WHERE users.username = :username');
  $tag->execute(array(
  'username' => $_SESSION['login_data']['username']));
   while ($tag_data = $tag->fetch())
   {
     array_push($_SESSION['tagArray'], $tag_data['tag_name']);
   }
   throw new Exception(' Votre dictionnaire ' . $tabName . ' a bien été crée');

}} catch (\Exception $e)
{
  echo $e->getMessage();
}
}

function changeTagChoice ()
{
    try {
      if (isset($_POST['tagName'])) {
        $db = dbConnect();
        $lang = $db->prepare('SELECT language_1, language_2 FROM tags WHERE tag_name = :tag_name');
        $lang->execute(array(
          'tag_name' => $_POST['tagName']));
          $langue = $lang->fetch();
          $_SESSION['personel_language_array'] = $langue;
      // vider mot consulter dictionnaire precedent
      $_SESSION['wordsListArray'] = array();
      $_SESSION['translationsListArray'] = array();
      }
    } catch (\Exception $e) {

    }
}

function languageId ($language)
{
  switch ($language) {
    case 'Polonais':
      $language_Id = 1;
      break;
    case 'Français':
      $language_Id = 2;
      break;
      case 'Anglais':
        $language_Id = 3;
        break;
      case 'Allemand':
        $language_Id = 4;
        break;
    default:
      $language_Id = 0;
      break;
  }
  return $language_Id;
}

function addaword ()
{
  try {
    if (empty($_SESSION['personel_language_array']))
    {
      throw new Exception('Veuillez choisir un dictionnaire');
    }
    elseif (empty(trim($_POST['addWord1'])) or empty(trim($_POST['addWord2'])))
    {
      throw new Exception('Veuillez ajouter un mot et sa traduction');
    }
    elseif (isset($_POST['language1'], $_POST['language2'], $_POST['addWord1'], $_POST['addWord2']))
    {
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
   }
   $reqData->closeCursor();
   $word->closeCursor();
  // unset($dataVerify);

  } catch (\Exception $e) {
    echo $e->getMessage();
  }
}


function showWordList()
{
  try {
    if (empty($_SESSION['personel_language_array']))
    {
      throw new Exception('Veuillez choisir un dictionnaire');
    }
    else

    $language_one_id = languageId($_SESSION['personel_language_array'][0]);
    $language_two_id = languageId($_SESSION['personel_language_array'][1]);
    if (isset($_SESSION['login_data']['id_user'])) {
      $db = dbConnect();
      $wd = $db->prepare('SELECT word, translation FROM words WHERE id_user = :id_user AND id_language_word = :id_language_word AND id_language_translation = :id_language_translation');
      $wd->execute(array(
        'id_user' => $_SESSION['login_data']['id_user'],
        'id_language_word' => $language_one_id,
        'id_language_translation' => $language_two_id,
        ));
        $_SESSION['wordsListArray'] = array();
        $_SESSION['translationsListArray'] = array();
         while ($wordsList = $wd->fetch())
         {
           array_push($_SESSION['wordsListArray'], $wordsList['word']);
           array_push($_SESSION['translationsListArray'], $wordsList['translation']);
         }
         //print_r($_SESSION);
            $wd->closeCursor();
    }
  } catch (\Exception $e) {
    echo $e->getMessage();
  }
}

function dbConnect()
{
    try
    {
        $db = new PDO('mysql:host=localhost;dbname=dictionary;charset=utf8', 'root', '');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }
}
