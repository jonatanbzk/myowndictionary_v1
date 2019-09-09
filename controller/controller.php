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
  require('view/dictionaryPage.php');
}

function addWord ()
{
   addaword ();
   require('view/dictionaryPage.php');
}

function showWord ()
{
  $wd = showWordList();
  require('view/dictionaryPage.php');
}

function erase ()
{
  $ew = eraseAWord();
  $wd = showWordList();
  require('view/dictionaryPage.php');
}

function disconnect ()
{
  session_unset();
  $_SESSION['error'] = 'Vous êtes bien déconnecté';
  header('Location: view/login_Page.php');
}
