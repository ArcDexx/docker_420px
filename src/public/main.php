<?php
  include_once('models/image.php');
  include_once('controller/session.php');

  checkSession();
  deleteAllTmpFiles();
  
  $image = new Image();
  if (isset($_FILES['fileUp']))
  {
    try
    {
      $image->loadImageFromFile($_FILES['fileUp']);
      $successSubmit = true;
    }
    catch (Imagine\Exception\InvalidArgumentException $e)
    {
      $failSubmit = true;
    }
  }

  if (isset($_GET['action']))
  {
    if ($_GET['action'] === 'delete')
      deletePicture($_GET['image']);
    else if ($_GET['action'] === 'download_zip')
      downloadZip();
    else if ($_GET['action'] === 'download_gif')
      downloadGif();
    else if ($_GET['action'] === 'download_image' && getImageOwner($_GET['image']) === getUserId(getUserLogin()))
      downloadImage($_GET['image']);
    else if ($_GET['action'] === 'show_gif')
      $gifname = createGif();
  }

  $pictures = getUserPictures(getUserLogin());
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
      <a class="navbar-brand" href="main.php">420px</a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="main.php">Dashboard</a></li>
    </ul>
    <ul class="nav navbar-nav">
      <li><a href="explore.php">Explore</a></li>
    </ul>
    <ul class="nav navbar-nav">
      <li><a href="colorsearch.php">Color Search</a></li>
    </ul>
    <ul class="nav navbar-nav">
      <li><p class="navbar-btn">
        <a href="main.php?action=download_zip" class="btn btn-info">Télécharger ZIP</a></p>
      </li>
    </ul>
    <ul class="nav navbar-nav" style="margin-left: 10px">
      <li><p class="navbar-btn">
        <a href="main.php?action=show_gif" class="btn btn-info">Créer GIF</a></p>
      </li>
    </ul>
    <ul class="nav navbar-nav navbar-right" style="margin-right: 10px">
      <li><p class="navbar-btn">
        <a href="controller/disconnect.php" class="btn btn-danger">Déconnexion</a></p>
      </li>
    </ul>
  </div>
</nav>

<div class="container" align="center">
  <?php if (count($pictures) > 0)
    echo '<h2 style="margin-bottom: 30px;" align="center">Vos images ajoutées</h2>'; ?>
   <div class="row" align="center">

  <?php
    if (isset($failSubmit))
    {
      ?>
      <div class="alert alert-info">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Pas si vite !</strong> Veuillez sélectionner un fichier valide
      </div>
      <?php
    }
    else if (isset($successSubmit))
    {
      ?>
      <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Succès !</strong> Image ajoutée
      </div>
      <?php
    }
    else if (isset($gifname))
    {
      ?>
      <div id="myModalGif" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" style="width:420px; height:420px">
          <div class="modal-content">
              <div class="modal-body">
                  <img src="<?php echo $gifname; ?>" style="width:100%; height:100%;">
                    <a type="button" href="main.php?action=download_gif&image=<?php echo getImageId($item); ?>" class="btn btn-lg btn-info btn-block" style="margin-top: 15px">Télécharger</a>
              </div>
          </div>
        </div>
      </div>
      <script>$('#myModalGif').modal('show');</script>
      <?php
    }

    foreach (array_reverse($pictures) as $key => $item)
    {
      ?>
        <div class="col-md-3">
          <a data-toggle="modal" data-target="#myModal<?php echo $key; ?>" class="btn"><img src="<?php echo $item; ?>?=<?php echo substr(md5(rand()), 0, 7); ?>" class="img-thumbnail" width="200" height="200"></a>
          <div class="row" style="margin-bottom:60px;">
            <div class="btn-group">
              <a type="button" href="edit.php?image=<?php echo getImageId($item); ?>" class="btn btn-sm btn-primary" style="width:98px;">Editer</a>
              <a type="button" href="main.php?action=delete&image=<?php echo getImageId($item); ?>" class="btn btn-sm btn-danger" style="width:98px;">Supprimer</a>
            </div>
          </div>
          <div id="myModal<?php echo $key; ?>" class="modal fade" tabindex="-1" role="dialog">
            <div class="modal-dialog" style="width:420px; height:420px" >
              <div class="modal-content">
                  <div class="modal-body">
                      <img src="<?php echo $item; ?>?=<?php echo substr(md5(rand()), 0, 7); ?>" style="width:100%; height:100%;">
                        <a type="button" href="main.php?action=download_image&image=<?php echo getImageId($item); ?>" class="btn btn-lg btn-info btn-block" style="margin-top: 15px">Télécharger</a>
                        <a type="button" href="edit.php?image=<?php echo getImageId($item); ?>" class="btn btn-lg btn-primary btn-block">Editer</a>
                        <a type="button" href="main.php?action=delete&image=<?php echo getImageId($item); ?>" class="btn btn-lg btn-danger btn-block">Supprimer</a>
                  </div>
              </div>
            </div>
          </div>
        </div>
        <?php
    }
  ?>
  </div>
  <br/><br/>
  <div class="col-md-6   col-md-offset-3" align="center" style="border: 2px solid #33ccff;">
    <form action="main.php" method="post" enctype="multipart/form-data">
      <h3>Ajouter une image</h3></br>
      <input type="file" class="btn btn-default btn-file" name="fileUp"></br>
      <input type="submit" class="btn btn-lg btn-primary" value="Charger l'image" name="submit">
    </form>
  </div>
</div>
</body>
</html>
