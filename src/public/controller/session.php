<?php
  function setNewSession($name)
  {
    if (session_status() == PHP_SESSION_NONE)
      session_start();

    $_SESSION['user'] = $name;

    header("Location: main.php");
    exit;
  }

  function checkSession()
  {
    if (isset($_POST['disconnect']))
      disconnect();

    if (session_status() == PHP_SESSION_NONE)
    session_start();

    if (!isset($_SESSION['user']))
    {
      session_destroy();
      header("Location: login.php");
      exit;
    }
  }

  function getUserLogin()
  {
    checkSession();

    return $_SESSION['user'];
  }

  function redirectIfLogged()
  {
    if (session_status() == PHP_SESSION_NONE)
      session_start();

    if (isset($_SESSION['user']))
    {
      header("Location: main.php");
      exit;
    }
  }

  function disconnect()
  {
    if (session_status() == PHP_SESSION_NONE)
      session_start();

    unset($_SESSION['user']);
    session_destroy();

    header("Location: ../login.php");
    exit;
  }

  function deleteAllTmpFiles()
  {
    $files = scandir('tmp/');

    foreach ($files as $file)
    {
      if ($file === getUserLogin().'-undo' || $file === getUserLogin().'-all.gif')
        unlink('tmp/'.$file);
    }
  }
?>
