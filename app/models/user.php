<?php
  include_once('app/controller/dbhandler.php');

  class User
  {
    public $login;
    public $password;

    function isLoginLengthOk($login)
    {
        if (strlen($login) > 10)
           return false;
        else
           return true;
    }

    function isPasswordLengthOk($password)
    {
        if (strlen($password) < 4)
           return false;
        else
           return true;
    }
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

  class UserTests extends PHPUnit_Framework_TestCase
  {
      private $user;

      protected function setUp()
      {
          $this->user = new User();
      }

      protected function tearDown()
      {
          $this->user = NULL;
      }

      public function testIsLoginLengthOk()
      {
          $result = $this->user->isLoginLengthOk("bob");
          $this->assertTrue($result);
      }

      public function testIsPasswordLengthOk()
      {
          $result = $this->user->isPasswordLengthOk("bob");
          $this->assertFalse($result);
      }
  }

 ?>
