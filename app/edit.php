<?php
  include_once('controller/dbhandler.php');
  include_once('controller/session.php');
  include_once('models/image.php');
  header('Cache-Control: no-cache');

  checkSession();

  if (!isset($_GET['image']) || getImageOwner($_GET['image']) !== getUserId(getUserLogin()))
  {
      header('Location: main.php');
      exit;
  }

  $image_path = getImagePath($_GET['image']);

  if (isset($_GET['action']))
  {
    if ($_GET['action'] === 'contrast_up')
      contrastUp($image_path);
    else if ($_GET['action'] === 'contrast_down')
      contrastDown($image_path);
    else if ($_GET['action'] === 'brightness_up')
      brightnessUp($image_path);
    else if ($_GET['action'] === 'brightness_down')
      brightnessDown($image_path);
    else if ($_GET['action'] === 'sepia')
      sepia($image_path);
    else if ($_GET['action'] === 'grayscale')
      grayscale($image_path);
    else if ($_GET['action'] === 'gaussian')
      gaussian($image_path);
    else if ($_GET['action'] === 'edge')
      edge($image_path);
    else if ($_GET['action'] === 'emboss')
      emboss($image_path);
    else if ($_GET['action'] === 'mean')
      mean($image_path);
    else if ($_GET['action'] === 'negate')
      negate($image_path);
    else if ($_GET['action'] === 'pixelate')
      pixelate($image_path);
    else if ($_GET['action'] === 'undo')
    {
      if (file_exists('tmp/'.getUserLogin().'-undo'))
      {
        $imagine = new Imagine\Gd\Imagine();
        $image = imagecreatefromstring($imagine->open($image_path));

        $filename = 'tmp/'.getUserLogin().'-undo';
        file_put_contents($image_path, $imagine->open($filename));

        deleteAllTmpFiles();
      }
    }

    $image_path = getImagePath($_GET['image']);
  }
?>

<html>
<head><title>420px</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">420px</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="main.php">Home</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="margin-right: 10px">
      <li><p class="navbar-btn">
        <a href="controller/disconnect.php" class="btn btn-danger">Déconnexion</a></p>
      </li>
    </ul>
  </div>
</nav>
<div class="container">
  <h2 align="center">Editeur</h2><br/><br/>
  <img src="<?php echo $image_path;  ?>?=<?php echo substr(md5(rand()), 0, 7); ?>" class="col-md-offset-1 col-md-6 img-thumbnail" width="500" height="500" style="margin-right: 60px;">
  <div class="col-md-3 well" style="border: 1px solid #33ccff;" align="right">
    <?php
    if (file_exists('tmp/'.getUserLogin().'-undo'))
    {
      ?>
      <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=undo"type="button" class="btn btn-lg btn-danger btn-block" >Annuler effet</a>
      </br>
      <?php
    }
    ?>
    <div>
      <h4 class="pull-left" style="margin: 15px; ">Contraste</h4>
      <div class="btn-group" style="margin-right:15px;">
        <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=contrast_down"type="button" class="btn btn-lg btn-info" style="width:50px;">-</a>
        <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=contrast_up" type="button" class="btn btn-lg btn-info" name="test" style="width:50px;">+</a>
      </div>
    </div>
  </br>
    <div>
      <h4 class="pull-left" style="margin: 15px; ">Luminosité</h4>
      <div class="btn-group" style="margin-right:15px;">
        <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=brightness_down" type="button" class="btn btn-lg btn-info" style="width:50px;">-</a>
        <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=brightness_up" type="button" class="btn btn-lg btn-info" name="test" style="width:50px;">+</a>
      </div>
    </div>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=sepia" type="button" class="btn btn-lg btn-info btn-block">Sépia</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=grayscale" type="button" class="btn btn-lg btn-info btn-block">Niveau de gris</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=gaussian" type="button" class="btn btn-lg btn-info btn-block">Flou gaussien</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=edge" type="button" class="btn btn-lg btn-info btn-block">Détection des contours</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=emboss" type="button" class="btn btn-lg btn-info btn-block">Bosselage</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=mean" type="button" class="btn btn-lg btn-info btn-block">Effet imprécis</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=negate" type="button" class="btn btn-lg btn-info btn-block">Couleurs négatives</a>
  </br>
  <a href="edit.php?image=<?php echo $_GET['image']; ?>&action=pixelate" type="button" class="btn btn-lg btn-info btn-block">Pixelisation</a>
  </div>
</div>
</body>
</html>
