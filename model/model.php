<?php
/* Namespace alias. */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// function send email
function emailSend($subject, $body, $email)
{
  require 'vendor/autoload.php';
  $mail= new PHPMailer();
  $mail->CharSet = 'UTF-8';
  $mail->Host = PHPMailer_HOST;
  $mail->isSMTP();
  $mail->SMTPAuth = true;
  $mail->Username = PHPMailer_USER;
  $mail->Password = PHPMailer_PASSWORD;
  $mail->SMTPSecure = PHPMailer_SMTP; // or TLS
  $mail->Port = PHPMailer_PORT; //or 587 if TLS
  $mail->Subject = $subject;
  $mail->isHTML(true);
  $mail->Body = $body;
  $mail->setFrom(PHPMailer_USER, 'myowndictionary');
  $mail->addAddress($email);
  if ($mail->send()) {
  }
  else {
    $_SESSION['error'] = I('model_email_no_send');
  }
}


$form_data = array();
// create account
function postSignUp()
{
  global $loc;
  global $form_data;
  $username=$_POST['username'];
  $password=$_POST['password'];
  $email=$_POST['email'];
  $pass_hache = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $form_data = array (
    'username' => $_POST['username'],
    'password' => $_POST['password'],
    'email' => $_POST['email']);
  $user_activation_code = md5(rand());
  $email_verify = "no";
  $db = dbConnect();
  $reqData = $db->prepare('SELECT username, email FROM users WHERE
    username= :username OR email= :email');
  $reqData->execute(array(
  'username' => $username,
  'email' => $email,
));
  $dataVerify = $reqData->fetch();
  if ($dataVerify['username'] == $username)
  {
    $_SESSION['error'] = I('model_username_used');
    require('view/sign_up.php');
  }
  elseif ($dataVerify['email'] == $email)
  {
    $_SESSION['error'] = I('model_email_used');
    require('view/sign_up.php');
  }
  else
  {
    $reqData->closeCursor();
    $userCreate = $db->prepare('INSERT INTO users(
      username,
      password,
      email,
      user_activation_code,
      email_verify,
      registration_date
    )
      VALUES(
        :username,
        :password,
        :email,
        :user_activation_code,
        :email_verify,
        NOW()
      )');
    $userCreate->execute(array(
    'username' => $username,
	  'password' => $pass_hache,
    'email' => $email,
    'user_activation_code' => $user_activation_code,
    'email_verify' => $email_verify
    ));
    //email verification send
    $subject = I('model_email_verification');
    $body = "Hello  " . $username . "<br>
    <a href='http://35.181.46.138/index.php?action=emailconfirm&amp;email=" .
    $email . "&amp;code=" . $user_activation_code . "'>" .
    I('model_email_link') . "</a>";
    emailSend($subject, $body, $email);
    $_SESSION['error'] = I('model_check_email');
    require('view/login_Page.php');
  }
}


$test_login_data = array();
function logIn()
{
  global $test_login_data;
  $test_login_data = array (
    'username' => $_POST['username'],
    'password' => $_POST['password']);
  $username = $_POST['username'];
  $db = dbConnect();
  $log = $db->prepare('SELECT
    id_user,
    password,
    email,
    email_verify,
    user_activation_code
    FROM users WHERE username = :username'
  );
  $log->execute(array(
  'username' => $username));
  $resultat = $log->fetch();
  //password verification
  if (!$resultat)
  {
    $_SESSION['error'] = I('model_wrong_id');
    require('view/login_Page.php');
    exit();
  }
  else
  {
    if (password_verify($_POST['password'], $resultat['password']))
    {
      if ($resultat['email_verify'] == "no")
      {
        $userMail = $resultat['email'];
        $userCode = $resultat['user_activation_code'];
        $_SESSION['error'] = I('model_confirm_email') . "<br> <a href=
        'http://35.181.46.138/index.php?action=emailconfirmresend&amp;email="
         . $userMail . "&amp;code=" . $userCode . "'>" .
         I('model_click') . "</a>";
        require('view/login_Page.php');
        exit();
      }
      elseif ($resultat['email_verify']=="yes")
      {
        $test_login_data = array();
        $_SESSION['login_data'] = array (
          'username' => $_POST['username'],
          'id_user' => $resultat['id_user']);
          $log->closeCursor();
      }
    }
    else
    {
      $_SESSION['error'] = I('model_wrong_id');
      require('view/login_Page.php');
      exit();
    }
  }
}


// convert id language to language string
function languageToId($id_lang)
{
  $languageList = array (
    'Polish', 'French', 'English', 'German', 'Italian', 'Russian',
    'Portuguese', 'Spanish', 'Esperanto'
  );
  if (is_int($id_lang) and $id_lang > 0 and $id_lang < 10) {
      $lang = I($languageList[$id_lang-1]);
    } else {
      $lang = $id_lang;
    }
  return $lang;
}


// get user dictionary tag
function getTag()
{
  $_SESSION['tagArray'] = array();
  $db = dbConnect();
  $tag = $db->prepare('SELECT tag_name FROM tags INNER JOIN users
    ON tags.id_user = users.id_user WHERE users.username = :username');
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
  // verify if the user have this dictionary
  $IfDictExist1 = $_POST['language1'] . '/' . $_POST['language2'];
  $IfDictExist2 = $_POST['language2'] . '/' . $_POST['language1'];
    if (in_array($IfDictExist1, $_SESSION['tagArray']) or
    in_array($IfDictExist2, $_SESSION['tagArray']))
    {
      $_SESSION['error'] = I('model_dictionary_exist');
    }
    else
    {
      $language1=$_POST['language1'];
      $language2=$_POST['language2'];
      $id_user=$_SESSION['login_data']['id_user'];
      $tabName = $language1 . '/' . $language2;
      $tabTest = array($language1, $language2);   // to verification
      sort($tabTest);
      $tabName2 = $tabTest[0] . '/' . $tabTest[1];
      $db = dbConnect();
      $tabCreate = $db->prepare('INSERT INTO tags(
        tag_name,
        tag_name2,
        id_user,
        language_1,
        language_2,
        add_date
      )
      VALUES(
        :tag_name,
        :tag_name2,
        :id_user,
        :language_1,
        :language_2,
        NOW())'
      );
      $tabCreate->execute(array(
        'tag_name' => $tabName,
        'tag_name2' => $tabName2,
        'id_user' => $id_user,
        'language_1' => $language1,
        'language_2' => $language2,
      ));
      $tabCreate->closeCursor();
      // refresh tagArray on dictionaryPage.php when new dictionary is add
      $_SESSION['tagArray'] = array();
      $tag = $db->prepare('SELECT tag_name FROM tags INNER JOIN users
        ON tags.id_user = users.id_user WHERE users.username = :username');
      $tag->execute(array(
        'username' => $_SESSION['login_data']['username']));
      while ($tag_data = $tag->fetch())
      {
        array_push($_SESSION['tagArray'], $tag_data['tag_name']);
      }
      $_SESSION['error'] = I('model_dictionary') . I(languageToId($language1))
       . ' / ' . I(languageToId($language2)) . I('model_create');
      $tag->closeCursor();
    }
}


function changeTagChoice()
{
  $db = dbConnect();
  $lang = $db->prepare('SELECT language_1, language_2 FROM tags
    WHERE tag_name = :tag_name');
  $lang->execute(array(
    'tag_name' => $_POST['tagName']));
  $langue = $lang->fetch();
  $_SESSION['personel_language_array'] = $langue;
  $_SESSION['wordsListArray'] = array();
  $_SESSION['translationsListArray'] = array();
  }


function addaword()
{
  $id_language1 = $_POST['language1'];
  $id_language2 = $_POST['language2'];
  $word = $_POST['addWord1'];
  $translation = $_POST['addWord2'];
  $idUser = $_SESSION['login_data']['id_user'];
  $db = dbConnect();
  $reqData = $db->prepare('SELECT word, translation FROM words
    WHERE id_user = :iduser
    AND id_language_word = :id_language1
    AND id_language_translation = :id_language2
    AND word = :word');
  $reqData->execute(array(
    'iduser' => $idUser,
    'id_language1' => $id_language1,
    'id_language2' => $id_language2,
    'word' => $word,
  ));
  $dataVerify = $reqData->fetch();
  if (!empty($dataVerify))
  {
    $_SESSION['error'] = I('model_word_exist');
    $reqData->closeCursor();
  }
  else
  {
    $reqData->closeCursor();
    $words = $db->prepare('INSERT INTO words(
      word,
      translation,
      id_language_word,
      id_language_translation,
      id_user,
      add_date
    )
    VALUES(
      :word,
      :translation,
      :id_language_word,
      :id_language_translation,
      :id_user,
      NOW()
    )');
    $words->execute(array(
      'word' => $_POST['addWord1'],
      'translation' => $_POST['addWord2'],
      'id_language_word' => $id_language1,
      'id_language_translation' => $id_language2,
      'id_user' => $_SESSION['login_data']['id_user'],
      ));
      $words->closeCursor();
  }
}


function showWordList()
{
  $language_one_id = $_SESSION['personel_language_array'][0];
  $language_two_id = $_SESSION['personel_language_array'][1];
  $db = dbConnect();
  $wd = $db->prepare('SELECT id_word, word, translation FROM words
    WHERE id_user = :id_user
    AND id_language_word = :id_language_word
    AND id_language_translation = :id_language_translation
    ORDER BY word');
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
      array_push($_SESSION['wordsAndTranslationArray']['words'],
      $wordsList['word']);
      array_push($_SESSION['wordsAndTranslationArray']['translations'],
      $wordsList['translation']);
      array_push($_SESSION['wordsAndTranslationArray']['ids'],
      $wordsList['id_word']);
    }
  $wd->closeCursor();
}


function eraseAWord()
{
  $idWord = $_POST['idWord'];
    $db = dbConnect();
    $ew = $db->prepare('DELETE FROM words WHERE id_word = :idWord');
    $ew->execute(array(
      'idWord' => $idWord,
    ));
    $ew->closeCursor();
}


function editAWord()
{
  $idWord = $_POST['idWord'];
  $newWord = $_POST['newWord'];
  $newTranslation = $_POST['newTranslation'];
  if (!empty($idWord))
  {
    $db = dbConnect();
    $editw = $db->prepare('UPDATE words
      SET word = :newWord, translation = :newTranslation
      WHERE id_word = :idWord');
    $editw->execute(array(
      'newWord' => $newWord,
      'newTranslation' => $newTranslation,
      'idWord' => $idWord,
    ));
    $editw->closeCursor();
  }
}


$testDirection = 0;
function startTest ()
{
  global $testDirection;
  if (!empty($_POST['numberQuestion']) and $_POST['numberQuestion']>0)
  {
    $nbrQuestion = $_POST['numberQuestion'];
  }
  else
  {
    $nbrQuestion = 10;
  }
  $language = explode("/", $_POST['typeTest']);
  $db = dbConnect();
  $test = $db->prepare('SELECT word, translation FROM words
    WHERE id_user = :id_user
    AND id_language_word = :id_language_word
    AND id_language_translation = :id_language_translation
    ORDER BY RAND() LIMIT :limit');
  $test->execute(array(
    'id_user' => $_SESSION['login_data']['id_user'],
    'id_language_word' => $_SESSION['personel_language_array'][0],
    'id_language_translation' => $_SESSION['personel_language_array'][1],
    'limit' => $nbrQuestion,
  ));
  $_SESSION['testArray'] = array(
    'words' => array(), 'translations' => array()
  );
  while ($testList = $test->fetch())
  {
    array_push($_SESSION['testArray']['words'], $testList['word']);
    array_push(
      $_SESSION['testArray']['translations'], $testList['translation']);
  }
$test->closeCursor();
  if ($_SESSION['personel_language_array'][0]==$language[0]
  and $_SESSION['personel_language_array'][1]==$language[1])
  {
    $testDirection = 1;
  }
  elseif ($_SESSION['personel_language_array'][1]==$language[0]
  and $_SESSION['personel_language_array'][0]==$language[1])
  {
    $testDirection = 2;
  }
  elseif ($_POST['typeTest'] == "random")
  {
    $testDirection = 3;
  }
}


$resultArray = array();
$evaluationNote = "";
$comment ="";
function testRecord()
{
  global $resultArray;
  global $evaluationNote;
  global $comment;
  $testLength = $_POST['testLength'];
  $testDirection = $_POST['testDirection'];
  $point = 0;
  $resultArray = array(
    'goodwords' => array(),
    'goodtranslations' => array(),
    'badwords' => array(),
    'badtranslations' => array(),
    'response' => array()
  );
  for ($i=0; $i < $testLength; $i++)
  {
    $answerName = 'answer' . ($i+1);
    if ($testDirection==1)
    {
      if ((strcasecmp($_POST[$answerName],
      $_SESSION['testArray']['translations'][$i]) == 0))
      {
        $point++;
        array_push($resultArray['goodwords'],
        $_SESSION['testArray']['words'][$i]);
        array_push($resultArray['goodtranslations'],
        $_POST[$answerName]);
      }
      else
      {
        array_push($resultArray['badwords'],
        $_SESSION['testArray']['words'][$i]);
        array_push($resultArray['badtranslations'],
        $_POST[$answerName]);
        array_push($resultArray['response'],
        $_SESSION['testArray']['translations'][$i]);
      }
    }
    elseif ($testDirection==2)
    {
      if ((strcasecmp($_POST[$answerName], $_SESSION['testArray']['words'][$i])
       == 0))
      {
        $point++;
        array_push($resultArray['goodwords'],
        $_SESSION['testArray']['translations'][$i]);
        array_push($resultArray['goodtranslations'],
        $_POST[$answerName]);
      }
      else
      {
        array_push($resultArray['badwords'],
        $_SESSION['testArray']['translations'][$i]);
        array_push($resultArray['badtranslations'],
        $_POST[$answerName]);
        array_push($resultArray['response'],
        $_SESSION['testArray']['words'][$i]);
      }
    }
    elseif ($testDirection==3)
    {
      $index = 'indexTest' . ($i+1);
      if ($_POST[$index]==0)
      {
        if ((strcasecmp(
        $_POST[$answerName], $_SESSION['testArray']['translations'][$i]) == 0))
        {
          $point++;
          array_push($resultArray['goodwords'],
          $_SESSION['testArray']['words'][$i]);
          array_push($resultArray['goodtranslations'],
          $_POST[$answerName]);
        }
        else
        {
          array_push($resultArray['badwords'],
          $_SESSION['testArray']['words'][$i]);
          array_push($resultArray['badtranslations'],
          $_POST[$answerName]);
          array_push($resultArray['response'],
          $_SESSION['testArray']['translations'][$i]);
        }
      }
      elseif ($_POST[$index]==1)
      {
        if ((strcasecmp(
          $_POST[$answerName], $_SESSION['testArray']['words'][$i]) == 0))
        {
          $point++;
          array_push($resultArray['goodwords'],
          $_SESSION['testArray']['translations'][$i]);
          array_push($resultArray['goodtranslations'],
          $_POST[$answerName]);
        }
        else
        {
          array_push($resultArray['badwords'],
          $_SESSION['testArray']['translations'][$i]);
          array_push($resultArray['badtranslations'],
          $_POST[$answerName]);
          array_push($resultArray['response'],
          $_SESSION['testArray']['words'][$i]);
        }
      }
    }
  }
  $evaluation = $point/$testLength;
if ($evaluation<(1/3))
  {
    $comment = "test_comment_one";
  }
  elseif ($evaluation>=(1/3) and $evaluation<(2/3)) {
    $comment = "test_comment_two";
  }
  elseif ($evaluation>=(2/3) and $evaluation<(4/5)) {
    $comment = "test_comment_three";
  }
  elseif ($evaluation>=(4/5)) {
    $comment = "test_comment_four";
  }
  $evaluationNote = ($evaluation*$testLength) . "/" . $testLength . "<br>";
  unset($_SESSION['testArray']);
}


function eraseTest ()
{
  if (isset($comment))
  {
    unset($comment);
  }
}


function verifyEmailAdress ()
{
  $email = $_GET['email'];
  $code = $_GET['code'];
  $db = dbConnect();
  $mail = $db->prepare(
    'SELECT id_user, email_verify
    FROM users
    WHERE email = :email AND user_activation_code = :user_activation_code'
  );
  $mail->execute(array(
    'email' => $email,
    'user_activation_code' => $code,
  ));
  $dataUser = $mail->fetch();
  if (empty($dataUser))
  {
    throw new Exception(I('model_count_noexist'));
    require('view/login_Page.php');
  }
  else
  {
    if ($dataUser['email_verify']=="no")
    {
      $editUser = $db->prepare(
        'UPDATE users
        SET email_verify = :email_verify
        WHERE email = :email'
      );
      $editUser->execute(array(
        'email_verify' => "yes",
        'email' => $email,
      ));
      $_SESSION['error'] = I('model_email_valid');
      require('view/login_Page.php');
      exit();
    }
    elseif ($dataUser['email_verify']=="yes")
    {
      $_SESSION['error'] = I('model_email_already_valid');
      require('view/login_Page.php');
      exit();
    }
  }
  $mail->closeCursor();
}


function resendActivationEmail()
{
  $subject = I('model_email_verification');
  $email = $_GET['email'];
  $user_activation_code = $_GET['code'];
  $body = "Hello <br>
  <a href='http://35.181.46.138/index.php?action=emailconfirm&amp;email=" .
  $email . "&amp;code=" . $user_activation_code . "'>" .
  I('model_email_link') . "</a>";
  emailSend($subject, $body, $email);
  $_SESSION['error'] = I('model_email_resend');
  require('view/login_Page.php');
  exit();
}


function resetpasswordverify()
{
  $email = $_POST['email'];
  $db = dbConnect();
  $emailverify = $db->prepare(
    'SELECT username, user_activation_code
    FROM users
    WHERE email = :email'
  );
  $emailverify->execute(array(
    'email' => $email,
  ));
  $datapasswordverify = $emailverify->fetch();
  if (empty($datapasswordverify))
  {
    $_SESSION['error'] = I('model_no_count');
  }
  else
  {
    $username = $datapasswordverify['username'];
    $code = $datapasswordverify['user_activation_code'];
    $subject = I('model_password_subject');
    $body ="Hello  " . $username . ".... <br> <a href=
    'http://35.181.46.138/index.php?action=resetpasswordlink&amp;username=" .
    $username . "&amp;code=" . $code . "'>" .
    I('model_password_link') . "</a>";
    emailSend($subject, $body, $email);
    $_SESSION['error'] = I('model_email_send');
  }
  $emailverify->closeCursor();
  require('view/login_Page.php');
}


function resetpasswordredirection()
{
    $username = $_GET['username'];
    $code = $_GET['code'];
    require("view/reset_password_password.php");
}


function newpasswordedit()
{
  $username = $_POST['username'];
  $code = $_POST['code'];
  $password_hache = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
  $db = dbConnect();
  $changepassword = $db->prepare(
    'UPDATE users
    SET password = :password
    WHERE username = :username AND user_activation_code = :code'
  );
  $changepassword->execute(array(
    'password' => $password_hache,
    'username' => $username,
    'code' => $code,
  ));
  $changepassword->closeCursor();
  $_SESSION['error'] = I('model_password');
  require('view/login_Page.php');
}

function dbConnect()
{
//$db = new PDO(
//  'mysql:host=127.0.0.1;dbname=dictionary;charset=utf8', 'root', '');
  $db = new PDO(DB_HOST_NAME_CHARSET, DB_USER, DB_PASSWORD);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $db->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );
return $db;
}
?>
