<?php
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['avatar'] ?? null;
    if ($file && $file['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024; // 2MB
        if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
            $newName = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($file['tmp_name'], 'uploads/' . $newName)) {
                $message = "Upload successful: $newName";
            } else {
                $message = "Error moving file";
            }
        } else {
            $message = "Invalid file type or size";
        }
    } else {
        $message = "File error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Avatar Upload</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <label>Avatar: <input type="file" name="avatar" required></label><br>
        <input type="submit" value="Upload">
    </form>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>
