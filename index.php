<?php
session_start();
require('controller/controller.php');
require('config.php');

try {
  if (isset($_GET['action']))
  {
    if ($_GET['action'] == 'signUpLink')
    {
      signUpLink();
    }
    elseif ($_GET['action'] == 'forgotPasswordLink')
    {
      forgotPasswordLink();
    }
    elseif ($_GET['action'] == 'haveAccountLink')
    {
      haveAccountLink();
    }
    elseif ($_GET['action'] == 'signUp')
    {
      if (empty(trim($_POST['username'])) or empty(trim($_POST['email'])))
      {
        throw new Exception(I('index_empty_input'));
        require('view/sign_up.php');
      }
      elseif (!isset($_POST['username'], $_POST['password'], $_POST['email']))
      {
        throw new Exception(I('index_empty_input'));
        require('view/sign_up.php');
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
        throw new Exception(I('index_empty_input'));
        require('view/login_Page.php');
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
        throw new Exception(I('index_two_languages'));
      }
      elseif ($_POST['language1'] == "select" or $_POST['language2'] == "select")
      {
        throw new Exception(I('index_two_languages'));
      }
      elseif ($_POST['language1'] == $_POST['language2'])
      {
        throw new Exception(I('index_different_languages'));
      }
      elseif (!in_array($_POST['language1'], $_SESSION['languagesArray']) or !in_array($_POST['language2'], $_SESSION['languagesArray']))
      {
        throw new Exception(I('index_no_choice'));
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
        throw new Exception(I('index_choose_dictionary'));
      }
      elseif (empty(trim($_POST['addWord1'])) or empty(trim($_POST['addWord2'])))
      {
        throw new Exception(I('index_add_word_add'));
      }
      elseif (!is_string($_POST['addWord1']) and !is_string($_POST['addWord2']))
      {
        throw new Exception(I('index_letter'));
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
        throw new Exception(I('index_choose_dictionary'));
      }
      elseif (empty(trim($_POST['newWord'])) or empty(trim($_POST['newTranslation'])))
      {
        throw new Exception(I('index_add_word'));
      }
      elseif (!is_string($_POST['newWord']) and !is_string($_POST['newTranslation']))
      {
        throw new Exception(I('index_letter'));
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
        throw new Exception(I('index_choose_dictionary'));
      }
      elseif (isset($_POST['numberQuestion']) and is_int($_POST['numberQuestion']) and $_POST['numberQuestion'] > 100)
      {
        throw new Exception(I('index_test_length'));
      }
      elseif ($_POST['typeTest'] == 'select') {
        throw new Exception(I('index_test_type'));
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
    elseif ($_GET['action'] == 'resetpassword')
    {
      if (!empty($_POST['email']))
      {
        resetpassword();
      }
      else
      {
        require('view/login_Page.php');
      }
    }
    elseif ($_GET['action'] == 'resetpasswordlink')
    {
      if (!empty($_GET['username']) and !empty($_GET['code']))
      {
        formresetpasswordredirection();
      }
      else
      {
        require('view/login_Page.php');
      }
    }
    elseif ($_GET['action'] == 'newpasswordform')
    {
      if (isset($_POST['newpassword'], $_POST['newpassword2'], $_POST['username'], $_POST['code']))
      {
        if (!empty($_POST['newpassword']) and $_POST['newpassword'] == $_POST['newpassword2'])
        {
          newpasswordform();
        }
        else
        {
          $_SESSION['error'] = I('index_password');
          require('view/login_Page.php');
        }
      }
      else
      {
        $_SESSION['error'] = I('index_error_password');
        require('view/login_Page.php');
      }
    }
    elseif ($_GET['action'] == 'deco')
    {
      disconnect ();
    }
    else
    {
      echo I('index_id');
    }
  }
else
{
  include('view/login_Page.php');
}
}
catch (\Exception $e)
{
    echo $e->getMessage();
    require('view/dictionaryPage.php');
}
