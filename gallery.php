<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}
// Simple gallery page: lists images from uploads/ directory
$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$webUploads = 'uploads';

function listImages($dir) {
    $files = [];
    if (!is_dir($dir)) return $files;
    $dh = opendir($dir);
    while (($file = readdir($dh)) !== false) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_file($path)) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif'])) {
                $files[] = $file;
            }
        }
    }
    closedir($dh);
    // sort newest first
    usort($files, function($a, $b) use ($dir) {
        return filemtime($dir . DIRECTORY_SEPARATOR . $b) - filemtime($dir . DIRECTORY_SEPARATOR . $a);
    });
    return $files;
}

$images = listImages($uploadsDir);
// optional status message from upload redirect
$status = isset($_GET['status']) ? $_GET['status'] : '';
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery - Art & Photo Gallery</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .delete-btn {
      display: inline-block;
      margin-top: 8px;
      margin-left: 8px;
      background: #ff4d4d;
      color: #fff;
      padding: 8px 18px;
      border-radius: 6px;
      text-decoration: none;
      font-weight: bold;
      border: none;
      cursor: pointer;
      transition: background 0.3s;
    }
    .delete-btn:hover {
      background: #ff3333;
    }
    .btn-group {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 8px;
    }
  </style>
</head>
<body>
  <header>
    <div class="container nav-container">
      <h1 class="logo">Art & Photo Gallery</h1>
      <nav id="nav-links">
        <a href="index.php">Home</a>
        <a href="gallery.php" class="active">Gallery</a>
        <a href="upload.html">Upload</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>
      </nav>
      <div class="menu-icon" id="menu-icon">☰</div>
    </div>
  </header>

  <section class="gallery-section">
    <h2>Art & Photo Collection</h2>
    <?php if ($status === 'success'): ?>
      <p class="notice success">✅ Artwork uploaded successfully.</p>
    <?php elseif ($status === 'error'): ?>
      <p class="notice error">❌ <?php echo htmlspecialchars($msg); ?></p>
    <?php endif; ?>
    <div class="grid">
        <!-- Featured images -->
        <?php 
          $featured = [
            'assets/images/art1.jpg',
            'assets/images/art2.jpg',
            'assets/images/art3.jpg',
            'assets/images/art4.jpg'
          ];
          foreach ($featured as $img): ?>
            <div class="thumb">
              <a href="<?php echo $img; ?>" target="_blank">
                <img src="<?php echo $img; ?>" alt="Featured Artwork">
              </a>
            </div>
          <?php endforeach; ?>
        <!-- Uploaded images -->
        <?php if (!empty($images)):
          foreach ($images as $img): ?>
            <div class="thumb">
              <a href="<?php echo $webUploads . '/' . rawurlencode($img); ?>" target="_blank">
                <img src="<?php echo $webUploads . '/' . rawurlencode($img); ?>" alt="<?php echo htmlspecialchars($img); ?>">
              </a>
              <?php 
                $metaFile = $uploadsDir . DIRECTORY_SEPARATOR . $img . '.txt';
                $title = '';
                $desc = '';
                if (file_exists($metaFile)) {
                  $meta = json_decode(file_get_contents($metaFile), true);
                  $title = !empty($meta['title']) ? htmlspecialchars($meta['title']) : '';
                  $desc = !empty($meta['description']) ? htmlspecialchars($meta['description']) : '';
                }
              ?>
              <?php if ($title): ?>
                <div class="img-title" style="margin-top:10px;font-weight:bold;"> <?php echo $title; ?> </div>
              <?php endif; ?>
              <?php if ($desc): ?>
              <div class="btn-group">
                <a class="desc-btn" href="view_description.php?img=<?php echo rawurlencode($img); ?>" style="display:inline-block;background:#00b4d8;color:#fff;padding:8px 18px;border-radius:6px;text-decoration:none;font-weight:bold;transition:background 0.3s;">View Description</a>
                <form action="delete_photo.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this image?');">
                  <input type="hidden" name="filename" value="<?php echo htmlspecialchars($img); ?>">
                  <button type="submit" class="delete-btn">Delete</button>
                </form>
              </div>
              <?php endif; ?>
              <?php if (!$desc): ?>
              <div class="btn-group">
                <form action="delete_photo.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this image?');">
                  <input type="hidden" name="filename" value="<?php echo htmlspecialchars($img); ?>">
                  <button type="submit" class="delete-btn">Delete</button>
                </form>
              </div>
              <?php endif; ?>
            </div>
          <?php endforeach;
        endif; ?>
    </div>
  </section>

  <footer>
    <p>© 2025 Art & Photo Gallery | All Rights Reserved</p>
  </footer>

  <script src="assets/js/script.js"></script>
  <script>
    function showDesc(title, desc) {
      const msg = title ? (title + "\n\n" + desc) : desc;
      alert(msg);
    }
  </script>
</body>
</html>
