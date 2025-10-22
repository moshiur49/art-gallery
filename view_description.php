<?php
// view_description.php: show title and description for an uploaded image
$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$img = isset($_GET['img']) ? $_GET['img'] : '';
$metaFile = $uploadsDir . DIRECTORY_SEPARATOR . $img . '.txt';
$title = '';
$desc = '';
if ($img && file_exists($metaFile)) {
  $meta = json_decode(file_get_contents($metaFile), true);
  $title = !empty($meta['title']) ? htmlspecialchars($meta['title']) : '';
  $desc = !empty($meta['description']) ? htmlspecialchars($meta['description']) : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Artwork Description</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .desc-container {
      max-width: 500px;
      margin: 80px auto;
      background: #181818;
      border-radius: 12px;
      box-shadow: 0 5px 20px #00b4d8;
      padding: 40px 30px;
      color: #fff;
      text-align: center;
    }
    .desc-title {
      font-size: 2em;
      color: #00b4d8;
      margin-bottom: 20px;
    }
    .desc-text {
      font-size: 1.2em;
      margin-bottom: 30px;
    }
    .back-btn {
      display: inline-block;
      background: #00b4d8;
      color: #fff;
      padding: 10px 24px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
      margin-top: 20px;
    }
    .back-btn:hover {
      background: #0096c7;
    }
  </style>
</head>
<body>
  <div class="desc-container">
    <div class="desc-title"> <?php echo $title ? $title : 'No Title'; ?> </div>
    <div class="desc-text"> <?php echo $desc ? nl2br($desc) : 'No Description Available.'; ?> </div>
    <a href="gallery.php" class="back-btn">← Back to Gallery</a>
  </div>
</body>
</html>
