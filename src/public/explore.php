<?php
  include_once('models/image.php');
  include_once('controller/session.php');

  $pictures = array();

  if (isset($_POST['to_explore']))
    $pictures = getUserPictures($_POST['to_explore']);
  else if (isset($_GET['user']))
    $pictures = getUserPictures($_GET['user']);
?>

<html>
<head><title>420px</title>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
        width: 50%;
        margin: auto;
    }
    </style>
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
  </div>
</nav>

<div class="container" align="center">

<h2>Veuillez entrer le pseudo d'un utilisateur pour voir ses images</h2>

<form action="explore.php" method="post">
  <input type="text" name="to_explore">
  <input type="submit" class="btn btn-lg btn-primary" value="Voir les images" name="submit">
</form>

  <?php
    if ((isset($_POST['to_explore']) || isset($_GET['user'])) && isset($pictures) && count($pictures) > 0)
    {
  ?>
  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php
        for ($i=0; $i < count($pictures); $i++)
        {
          if ($i == 0)
            echo '<li data-target="#myCarousel" data-slide-to="0" class="active"></li>';
          else
            echo '<li data-target="#myCarousel" data-slide-to="'.$i.'"></li>';
        }
      ?>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <?php
        for ($i = count($pictures) - 1; $i >= 0; $i--)
        {
          if ($i == count($pictures) - 1)
            echo '<div class="item active"><img src="'.$pictures[$i].'?='.substr(md5(rand()), 0, 7).'"></div>';
          else
            echo '<div class="item"><img src="'.$pictures[$i].'?='.substr(md5(rand()), 0, 7).'"></div>';
        }
      ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
  <?php
  }
  else if (isset($_POST['to_explore']) || isset($_GET['user']))
    echo '</br><h3>Aucun photo trouvée pour cet utilisateur</h3>';
  ?>

</div>
</body>
</html>
