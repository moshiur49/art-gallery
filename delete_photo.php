<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: gallery.php');
    exit;
}

$filename = isset($_POST['filename']) ? $_POST['filename'] : '';
if (!$filename) {
    header('Location: gallery.php?status=error&msg=' . urlencode('No file specified'));
    exit;
}

$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
$filepath = $uploadsDir . DIRECTORY_SEPARATOR . $filename;
$metafile = $filepath . '.txt';

// Security check: ensure file exists and is within uploads directory
if (!file_exists($filepath) || !is_file($filepath) || dirname($filepath) !== $uploadsDir) {
    header('Location: gallery.php?status=error&msg=' . urlencode('Invalid file'));
    exit;
}

// Delete the image and its metadata
if (unlink($filepath)) {
    if (file_exists($metafile)) {
        unlink($metafile);
    }
    header('Location: gallery.php?status=success&msg=' . urlencode('Image deleted successfully'));
} else {
    header('Location: gallery.php?status=error&msg=' . urlencode('Failed to delete image'));
}
exit;
?>