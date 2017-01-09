<?php
  require('vendor/autoload.php');
  include_once('controller/dbhandler.php');
  include_once('controller/session.php');

  use Imagine\Image\Box;
  use Imagine\Image\Point;

  class Image
  {
    private $path;

    public function getPath()
    {
      return $this->path;
    }

    public function loadImageFromFile($file)
    {
      $target_dir = "uploads/";
      $target_file = $target_dir.uniqid().getUserLogin().'_'.basename($file["name"]);
      $this->path = $target_file;

      move_uploaded_file($file["tmp_name"], $target_file);

      $imagine = new Imagine\Gd\Imagine();
      $imagine->open($target_file)->resize(new Box(420, 420))->save($target_file);

      $this->saveImageToDatabase();
    }

    private function saveImageToDatabase()
    {
      $dblink = new DatabaseHandler();

      $prepa = $dblink->getConnection()->prepare('INSERT INTO images (image, user_id, main_color) VALUES (?, ?, ?);');
      $prepa->execute(array($this->path, getUserId(getUserLogin()), getAverageColor($this->path)));
    }
  }

  function contrastDown($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_CONTRAST, +20);
    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function contrastUp($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_CONTRAST, -20);
    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function brightnessDown($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_BRIGHTNESS, -20);
    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function brightnessUp($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_BRIGHTNESS, +20);
    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function grayscale($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_GRAYSCALE);
    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function gaussian($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);
    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function sepia($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_GRAYSCALE);
    imagefilter($image, IMG_FILTER_COLORIZE, 90, 60, 30);

    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function edge($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_EDGEDETECT);

    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function emboss($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_EMBOSS);

    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function mean($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_MEAN_REMOVAL);

    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function negate($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_NEGATE);

    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function pixelate($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path));
    savePrevious($imagine->open($image_path), $image_path);

    imagefilter($image, IMG_FILTER_PIXELATE, 10);

    imagejpeg($image, $image_path, 100);

    imagedestroy($image);
  }

  function getAverageColor($image_path)
  {
    $imagine = new Imagine\Gd\Imagine();
    $image = imagecreatefromstring($imagine->open($image_path)->resize(new Box(1, 1)));

    $result = '#'.strtoupper(dechex(imagecolorat($image, 0, 0)));

    while (strlen($result) < 7)
      $result = $result.'0';

    return $result;
  }

  function updateAllColors($pictures)
  {
    foreach ($pictures as $key => $item)
      updateColor(getImageId($item), getAverageColor($item));
  }

  function downloadZip()
  {
    $zip = new ZipArchive();
    $filename = 'tmp/'.getUserLogin().'-all-'.uniqid().'.zip';
    $zip->open($filename, ZipArchive::CREATE);

    $pictures = getUserPictures(getUserLogin());

    foreach ($pictures as $key => $picture)
      $zip->addFile($picture, explode('/', $picture)[1]);

    file_put_contents($filename, $zip);

    $zip->close();

    header("Content-Type: application/zip");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length: ".filesize($filename));
    header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
    readfile($filename);

    unlink($filename);
  }

  function downloadImage($id)
  {
    $filename = getImagePath($id);

    header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
    readfile($filename);
  }

  function createGif()
  {
    $pictures = getUserPictures(getUserLogin());

    $frames = array();
    $durations = array();

    foreach ($pictures as $key => $picture)
    {
      array_push($frames, $picture);
      array_push($durations, 200);
    }

    $gc = new \GifCreator\GifCreator();
    $gc->create($frames, $durations, 5);

    $filename = 'tmp/'.getUserLogin().'-all.gif';
    file_put_contents($filename, $gc->getGif());

    return $filename;
  }

  function downloadGif()
  {
    $filename = 'tmp/'.getUserLogin().'-all.gif';

    if (!file_exists($filename))
      createGif();

    header("Content-Type: image/gif");
    header("Content-Transfer-Encoding: Binary");
    header("Content-Length: ".filesize($filename));
    header("Content-Disposition: attachment; filename=\"".basename($filename)."\"");
    readfile($filename);
  }

  function savePrevious($image, $path)
  {
    $filename = 'tmp/'.getUserLogin().'-undo';
    file_put_contents($filename, $image);
  }
?>
