<?php
  include_once('controller/session.php');
  include_once('controller/dbhandler.php');
  include_once('models/image.php');

  checkSession();

  updateAllColors(getUserPictures(getUserLogin()));

  $colors = getUserColors(getUserLogin());
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
  <div class="row">
 <?php
   if (count($colors) > 0)
     echo '<h2 align="center">Cliquez sur une couleur pour voir son image asssociée</h2></br>';
   else
     echo '<h2 align="center">Veuillez ajouter des images</h2>';

   foreach ($colors as $key => $item)
   {
     ?>
    <a data-toggle="modal" data-target="#myModal<?php echo $key; ?>" style="background-color:<?php echo $item; ?>; width:150px; height:150px;" class="btn"></a>
    <div id="myModal<?php echo $key; ?>" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" style="width:420px; height:420px">
        <div class="modal-content">
            <div class="modal-body">
                <img src="<?php echo getPictureFromColor(getUserLogin(), $item).'?='.substr(md5(rand()), 0, 7);; ?>" style="width:100%; height:420px;">
            </div>
        </div>
      </div>
    </div>
    <?php
  }
 ?>
 </div>
</div>

</body>
</html>
