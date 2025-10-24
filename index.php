<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Art & Photo Gallery</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .user-name {
      color: #00b4d8;
      font-weight: bold;
      margin-left: 20px;
    }
    /* Featured image captions */
    .featured .grid { display:flex; gap:18px; flex-wrap:wrap; justify-content:center; }
  .featured figure { margin:0; text-align:center; max-width:220px; position:relative; overflow:hidden; }
  .featured img { display:block; width:100%; height:auto; border-radius:8px; transition:transform .25s ease; }
  .featured figure:hover img { transform:scale(1.04); }
    .featured figcaption {
      position:absolute;
      left:6px;
      right:6px;
      bottom:6px;
      padding:8px 10px;
      background:linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.6) 100%);
      color:#fff;
      font-weight:700;
      font-size:14px;
      transform:translateY(8px);
      transition:transform .22s ease, opacity .22s ease;
      opacity:0.98;
      border-radius:6px;
    }
    .featured figure:hover figcaption { transform:translateY(0); opacity:1; }
  </style>
</head>
<body>
  <header>
    <div class="container nav-container">
      <h1 class="logo">Art & Photo Gallery</h1>
      <nav id="nav-links">
        <a href="index.php" class="active">Home</a>
        <a href="gallery.php">Gallery</a>
        <a href="upload.html">Upload</a>
        <a href="about.html">About</a>
        <a href="contact.html">Contact</a>
      </nav>
      <?php if (isset($_SESSION['user'])): ?>
        <span class="user-name"><?php echo htmlspecialchars($_SESSION['user']); ?></span>
        <a href="logout.php" style="margin-left:12px;background:#ff4d4d;color:#fff;padding:6px 12px;border-radius:6px;text-decoration:none;">Logout</a>
      <?php endif; ?>
      <div class="menu-icon" id="menu-icon">☰</div>
    </div>
  </header>

  <section class="hero">
    <h2>Welcome to the Art & Photo Gallery</h2>
    <p>Showcasing the creativity of artists and photographers around the world.</p>
    <a href="gallery.php" class="btn">Explore Gallery</a>
    <div style="margin-top:30px;text-align:center;">
      <?php if (!isset($_SESSION['user'])): ?>
        <a href="login.php" class="btn" style="margin-right:15px;">Login</a>
        <a href="register.php" class="btn">Register</a>
      <?php endif; ?>
    </div>
  </section>

  <section class="featured">
    <h2>Featured Artworks</h2>
    <div class="grid">
      <figure>
        <img src="assets/images/art1.jpg" alt="Art 1">
        <figcaption>The traditionl deer</figcaption>
      </figure>
      <figure>
        <img src="assets/images/art2.jpg" alt="Art 2">
        <figcaption>Rich culture</figcaption>
      </figure>
      <figure>
        <img src="assets/images/art3.jpg" alt="Art 3">
        <figcaption>close yet far</figcaption>
      </figure>
      <figure>
        <img src="assets/images/art4.jpg" alt="Art 4">
        <figcaption>Weolcome</figcaption>
      </figure>
      <figure>
        <img src="assets/images/art5.jpg" alt="Art 5">
        <figcaption>chalooo</figcaption>
      </figure>
      <figure>
        <img src="assets/images/art6.jpg" alt="Art 6">
        <figcaption>dream Land</figcaption>
      </figure>
    </div>
  </section>

  <footer>
    <p>© 2025 Art & Photo Gallery | All Rights Reserved</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
