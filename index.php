<?php
session_start();
require('controller/controller.php');

try {

  if (isset($_GET['action']))
  {
    if ($_GET['action'] == 'signUp')
    {
      register();
    }
    elseif ($_GET['action'] == 'logIn')
    {
      connect();
    }
    elseif ($_GET['action'] == 'addUserTab')
    {
      addtab ();
    }
    elseif ($_GET['action'] == 'changeTag')
    {
      changeTag ();
    }
    elseif ($_GET['action'] == 'addWord')
    {
      addWord ();
    }
    elseif ($_GET['action'] == 'showWordList')
    {
      showWord ();
    }
    elseif ($_GET['action'] == 'deco')
    {
      disconnect ();
    }
    else
    {
      echo 'Erreur : aucun identifiant de billet envoyé';
    }
  }
  else
  {
     header('Location: view/login_Page.php');
  }

  } catch (\Exception $e)
{
    echo 'Erreur : ' . $e->getMessage();
}
