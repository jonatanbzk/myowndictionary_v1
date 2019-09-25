<?php
  require_once('model/model.php');

function register ()
{
  $userCreate = postSignUp();
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
   $word = addaword ();
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

function disconnect ()
{
  session_destroy();
  $_SESSION['error'] = 'Vous êtes bien déconnecté';
  header('Location: view/login_Page.php');
}
