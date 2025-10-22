<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}

// Handle uploads securely and redirect back to gallery
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header('Location: upload.html');
    exit;
}

$title = isset($_POST['title']) ? trim($_POST['title']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';

$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    header('Location: gallery.php?status=error&msg=' . urlencode('No file uploaded or upload error'));
    exit;
}

$file = $_FILES['image'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$allowed = ['jpg','jpeg','png','gif'];
if (!in_array($ext, $allowed)) {
    header('Location: gallery.php?status=error&msg=' . urlencode('Invalid file type'));
    exit;
}

// sanitize original name and generate unique filename
$base = pathinfo($file['name'], PATHINFO_FILENAME);
$base = preg_replace('/[^A-Za-z0-9-_ ]/', '', $base);
$base = substr($base, 0, 200);
$timestamp = time();
$safeName = $base . '_' . $timestamp . '.' . $ext;
$target = $uploadsDir . DIRECTORY_SEPARATOR . $safeName;

if (move_uploaded_file($file['tmp_name'], $target)) {
    // save metadata sidecar (optional)
    $meta = [
        'title' => $title,
        'description' => $description,
        'uploaded_at' => date('c')
    ];
    file_put_contents($uploadsDir . DIRECTORY_SEPARATOR . $safeName . '.txt', json_encode($meta));

    header('Location: gallery.php?status=success');
    exit;
} else {
    header('Location: gallery.php?status=error&msg=' . urlencode('Failed to move uploaded file'));
    exit;
}

?>
