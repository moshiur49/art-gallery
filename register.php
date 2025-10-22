<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $usersFile = __DIR__ . '/users.txt';
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  if (strlen($username) < 3 || strlen($password) < 4) {
    $error = 'Username must be at least 3 characters and password at least 4.';
  } else {
        $exists = false;
        if (file_exists($usersFile)) {
            $lines = file($usersFile);
            foreach ($lines as $line) {
                list($user, ) = explode(':', trim($line));
                if ($user === $username) {
                    $exists = true;
                    break;
                }
            }
        }
        if ($exists) {
            $error = 'Username already exists.';
    } else {
      $hash = password_hash($password, PASSWORD_DEFAULT);
      file_put_contents($usersFile, "$username:$hash\n", FILE_APPEND);
      header('Location: login.php');
      exit;
    }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
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
    <h2>Register</h2>
    <?php if ($error): ?><div class="error"> <?php echo $error; ?> </div><?php endif; ?>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" class="btn">Register</button>
    </form>
    <p style="margin-top:20px;">Already have an account? <a href="login.php" style="color:#00b4d8;">Login</a></p>
  </div>
</body>
</html>
