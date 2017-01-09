<?php
  include_once('controller/dbhandler.php');

  class User
  {
    public $login;
    public $password;
  }

  function isLoginFree($name)
  {
    $dblink = new DatabaseHandler();

    $select = $dblink->getConnection()->query('SELECT * FROM users WHERE login = \''.$name.'\';');
    $select->setFetchMode(PDO::FETCH_OBJ);

    $user = new User();
    $user = $select->fetch();

    return empty($user);
  }

  function insertNewUser($login, $password)
  {
    $dblink = new DatabaseHandler();

    $prepa = $dblink->getConnection()->prepare('INSERT INTO users (login, password) VALUES (?, ?);');
    $prepa->execute(array($login, $password));
  }

  function accountExists($login, $password)
  {
    $dblink = new DatabaseHandler();

    $select = $dblink->getConnection()->query('SELECT * FROM users WHERE login = \''.$login.'\' AND password = \''.$password.'\';');
    $select->setFetchMode(PDO::FETCH_OBJ);

    $user = new User();
    $user = $select->fetch();

    return !empty($user);
  }
 ?>
