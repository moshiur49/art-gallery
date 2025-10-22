<?php
session_start();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usersFile = __DIR__ . '/users.txt';
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $found = false;
  if (file_exists($usersFile)) {
    $lines = file($usersFile);
    foreach ($lines as $line) {
      $parts = explode(':', trim($line));
      $user = $parts[0];
      $pass = $parts[1];
      if ($user === $username && password_verify($password, $pass)) {
        $_SESSION['user'] = $username;
        $found = true;
        break;
      }
    }
  }
  if ($found) {
    header('Location: gallery.php');
    exit;
  } else {
    $error = 'Invalid username or password.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="assets/css/style.css">
  <style>
    .form-container { max-width: 400px; margin: 80px auto; background: #181818; border-radius: 12px; box-shadow: 0 5px 20px #00b4d8; padding: 40px 30px; color: #fff; }
    .form-container h2 { color: #00b4d8; margin-bottom: 20px; }
    .form-container input { margin-bottom: 18px; }
    .error { color: #ff4d4d; margin-bottom: 15px; }
    .btn { width: 100%; }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Login</h2>
    <?php if ($error): ?><div class="error"> <?php echo $error; ?> </div><?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn">Login</button>
    </form>
    <p style="margin-top:20px;">Don't have an account? <a href="register.php" style="color:#00b4d8;">Register</a></p>
  </div>
</body>
</html>
