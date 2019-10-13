<?php
require_once('language/locales.php');
require_once('model/model.php');

function register ()
{
  $userCreate = postSignUp();
}

function signUpLink()
{
  require('view/sign_up.php');
}

function forgotPasswordLink ()
{
  require('view/reset_password_email.php');
}

function haveAccountLink ()
{
  require('view/login_Page.php');
}

function connect ()
{
  $log = logIn();
  $languages = getLanguages();
  $tag = getTag();
  require('view/dictionaryPage.php');
}

function addtab ()
{
  $tabCreate = addUserDictionary();
  require('view/dictionaryPage.php');
}

function changeTag()
{
  $lang = changeTagChoice ();
  $wd = showWordList();
  require('view/dictionaryPage.php');
}

function addWord ()
{
   $words = addaword ();
   $wd = showWordList();
   require('view/dictionaryPage.php');
}

function erase ()
{
  $ew = eraseAWord();
  $wd = showWordList();
  require('view/dictionaryPage.php');
}

function edit ()
{
  $editw = editAWord();
  $wd = showWordList();
  require('view/dictionaryPage.php');
}

function lunchtest ()
{
  $test = startTest ();
  require('view/dictionaryPage.php');
}

function testVerify ()
{
  testRecord ();
  require('view/dictionaryPage.php');
}

function closeTest()
{
  eraseTest ();
  require('view/dictionaryPage.php');
}

function emailconfirm()
{
  $mail = verifyEmailAdress ();
  require('view/dictionaryPage.php');
}

function emailconfirmresend()
{
  resendActivationEmail();
  require('view/dictionaryPage.php');
}

function resetpassword()
{
  $emailverify = resetpasswordverify();
  require('view/dictionaryPage.php');
}

function formresetpasswordredirection()
{
  resetpasswordredirection();
}

function newpasswordform()
{
  $changepassword = newpasswordedit ();
  require('view/dictionaryPage.php');
}

function disconnect ()
{
  session_destroy();
  $_SESSION['error'] = I('controller_disconnect');
  require('view/login_Page.php');
}
