<?php
  class DatabaseHandler
  {
    private static $connection;

    public static function getConnection()
    {
      if (!isset(self::$connection))
      {
        try
        {
	        $dsn = 'mysql:host=172.17.0.2;port=3306;dbname=myapp';
          self::$connection = new PDO($dsn, 'dev', '123456');
        }
        catch (PDOException $e)
        {
          echo $e->getMessage();
        }
      }

      return self::$connection;
    }
  }

  function getImagePath($id)
  {
    $dblink = new DatabaseHandler();

    $select = $dblink->getConnection()->query('SELECT image FROM images WHERE id = \''.$id.'\';');
    $select->setFetchMode(PDO::FETCH_OBJ);

    return $select->fetch()->image;
  }

  function getImageId($path)
  {
      $dblink = new DatabaseHandler();

      $select = $dblink->getConnection()->query('SELECT id FROM images WHERE image = \''.$path.'\';');
      $select->setFetchMode(PDO::FETCH_OBJ);

      return $select->fetch()->id;
  }

  function getImageOwner($id)
  {
    $dblink = new DatabaseHandler();

    $select = $dblink->getConnection()->query('SELECT user_id FROM images WHERE id = \''.$id.'\';');
    $select->setFetchMode(PDO::FETCH_OBJ);

    return $select->fetch()->user_id;
  }

  function getUserId($login)
  {
    $dblink = new DatabaseHandler();

    $select = $dblink->getConnection()->query('SELECT id FROM users WHERE login = \''.$login.'\';');
    $select->setFetchMode(PDO::FETCH_OBJ);

    return $select->fetch()->id;
  }

  function getAllUsers()
  {
    $dblink = new DatabaseHandler();
    $select = $dblink->getConnection()->query('SELECT login FROM users');
    $select->setFetchMode(PDO::PARAM_STR);

    return $select->fetchAll(PDO::FETCH_COLUMN, 0);
  }

  function getUserPictures($login)
  {
    $dblink = new DatabaseHandler();
    $select = $dblink->getConnection()->query('SELECT image FROM images WHERE user_id = '.getUserId($login));
    $select->setFetchMode(PDO::PARAM_STR);

    return $select->fetchAll(PDO::FETCH_COLUMN, 0);
  }

  function getUserColors($login)
  {
    $dblink = new DatabaseHandler();
    $select = $dblink->getConnection()->query('SELECT main_color FROM images WHERE user_id = '.getUserId($login));
    $select->setFetchMode(PDO::PARAM_STR);

    return $select->fetchAll(PDO::FETCH_COLUMN, 0);
  }

  function getPictureFromColor($login, $color)
  {
    $dblink = new DatabaseHandler();
    $select = $dblink->getConnection()->query('SELECT image FROM images WHERE main_color = "'.$color.'" AND user_id = '.getUserId($login));
    $select->setFetchMode(PDO::FETCH_OBJ);

    return $select->fetch()->image;
  }

  function deletePicture($id)
  {
    $dblink = new DatabaseHandler();

    $prepa = $dblink->getConnection()->prepare('DELETE FROM images WHERE id = ? AND user_id = ? LIMIT 1;');
    $prepa->execute(array($id, getUserId(getUserLogin())));
  }

  function updateColor($id, $color)
  {
    $dblink = new DatabaseHandler();

    $prepa = $dblink->getConnection()->prepare('UPDATE images SET main_color = ? WHERE id = ?');
    $prepa->execute(array($color, $id));
  }
?>
