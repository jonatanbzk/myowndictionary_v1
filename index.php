<?php
session_start();
require('controller/controller.php');

try {

  if (isset($_GET['action']))
  {
    if ($_GET['action'] == 'signUp')
    {
      if (empty(trim($_POST['username'])) or empty(trim($_POST['email'])))
      {
        throw new Exception('Veuiller compléter tout les champs');
        header('Location: view/sign_up.php');
      }
      elseif (!isset($_POST['username'], $_POST['password'], $_POST['email']))
      {
        throw new Exception('Veuiller compléter tout les champs');
        header('Location: view/sign_up.php');
      }
      else
      {
        register();
      }
    }
    elseif ($_GET['action'] == 'logIn')
    {
      if (!isset($_POST['username'], $_POST['password']))
      {
        throw new Exception('Veuiller compléter tout les champs');
        header('Location: view/login_Page.php');
        exit();
      }
      else
      {
        connect();
      }
    }
    elseif ($_GET['action'] == 'addUserTab')
    {
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
      elseif (!in_array($_POST['language1'], $_SESSION['languagesArray']) or !in_array($_POST['language2'], $_SESSION['languagesArray']))
      {
        throw new Exception('Ces langues ne font pas partie des choix possibles');
      }
      else
      {
        addtab ();
      }
    }
    elseif ($_GET['action'] == 'changeTag')
    {
      if (isset($_POST['tagName']))
      {
        changeTag ();
      }
    }
    elseif ($_GET['action'] == 'addWord')
    {
      if (empty($_SESSION['personel_language_array']))
      {
        throw new Exception('Veuillez choisir un dictionnaire');
      }
      elseif (empty(trim($_POST['addWord1'])) or empty(trim($_POST['addWord2'])))
      {
        throw new Exception('Veuillez ajouter un mot et sa traduction');
      }
      elseif (!is_string($_POST['addWord1']) and !is_string($_POST['addWord2']))
      {
        throw new Exception('Veuillez n\'utiliser que des lettres');
      }
      elseif (isset($_POST['language1'], $_POST['language2'], $_POST['addWord1'], $_POST['addWord2']))
      {
        addWord ();
      }
    }
    elseif ($_GET['action'] == 'eraseWord')
    {
      if (isset($_POST['idWord']))
      {
      erase ();
      }
    }
    elseif ($_GET['action'] == 'editWord')
    {
      if (empty($_SESSION['personel_language_array']))
      {
        throw new Exception('Veuillez choisir un dictionnaire');
      }
      elseif (empty(trim($_POST['newWord'])) or empty(trim($_POST['newTranslation'])))
      {
        throw new Exception('Veuillez ajouter un mot et sa traduction');
      }
      elseif (!is_string($_POST['newWord']) and !is_string($_POST['newTranslation']))
      {
        throw new Exception('Veuillez n\'utiliser que des lettres');
      }
      elseif (isset($_POST['idWord'], $_POST['newWord'], $_POST['newTranslation']))
      {
        edit ();
      }
    }
    elseif ($_GET['action'] == 'lunchTest')
    {
      if (empty($_SESSION['personel_language_array']))
      {
        throw new Exception('Veuillez choisir un dictionnaire');
      }
      elseif (isset($_POST['numberQuestion']) and is_int($_POST['numberQuestion']) and $_POST['numberQuestion'] > 100)
      {
        throw new Exception('Le test ne peut pas contenir plus de 100 questions');
      }
      elseif ($_POST['typeTest'] == 'select') {
        throw new Exception('Veuillez choisir le type de test voulu');
      }
      elseif (isset($_POST['typeTest'], $_POST['numberQuestion'], $_SESSION['login_data']['id_user']))
      {
        lunchTest ();
      }
    }
    elseif ($_GET['action'] == 'test')
    {
      if (isset($_SESSION['testDirection'], $_SESSION['testArray'])) {
        testVerify ();
      }
    }
    elseif ($_GET['action'] == 'closeTest')
    {
      closeTest();
    }
    elseif ($_GET['action'] == 'emailconfirm')
    {
      if (!empty($_GET['email']) and !empty($_GET['code']))
      {
        emailconfirm();
      }
    }
    elseif ($_GET['action'] == 'emailconfirmresend')
    {
      if (!empty($_GET['email']) and !empty($_GET['code']))
      {
        emailconfirmresend();
      }
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
}
catch (\Exception $e)
{
    echo $e->getMessage();
    require('view/dictionaryPage.php');
}
