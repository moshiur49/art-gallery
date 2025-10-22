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
      <img src="assets/images/art1.jpg" alt="Art 1">
      <img src="assets/images/art2.jpg" alt="Art 2">
      <img src="assets/images/art3.jpg" alt="Art 3">
      <img src="assets/images/art4.jpg" alt="Art 4">
    </div>
  </section>

  <footer>
    <p>© 2025 Art & Photo Gallery | All Rights Reserved</p>
  </footer>

  <script src="assets/js/script.js"></script>
</body>
</html>
