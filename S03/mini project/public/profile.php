<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/utils.php';

$username = $_SESSION['user'];
$users = getUsers();
$key = array_search($username, array_column($users, 'username'));
$user = $users[$key] ?? [];
$bio = $user['bio'] ?? '';
$avatar = $user['avatar'] ?? '';
$errors = [];
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = sanitize($_POST['bio'] ?? '');
    $file = $_FILES['avatar'] ?? null;

    if ($file && $file['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png'];
        $maxSize = 2 * 1024 * 1024;
        if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
            $newName = uniqid() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
            if (move_uploaded_file($file['tmp_name'], 'uploads/avatars/' . $newName)) {
                $avatar = $newName;
            } else {
                $errors[] = "Error uploading file";
            }
        } else {
            $errors[] = "Invalid file type or size";
        }
    }

    if (empty($errors)) {
        $users[$key]['bio'] = $bio;
        $users[$key]['avatar'] = $avatar;
        saveUsers($users);
        $message = "Profile updated";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Profile of <?php echo htmlspecialchars($username); ?></h1>
    <?php if ($avatar): ?>
        <img src="uploads/avatars/<?php echo htmlspecialchars($avatar); ?>" alt="Avatar">
    <?php endif; ?>
    <p>Bio: <?php echo htmlspecialchars($bio); ?></p>
    <?php if ($errors): ?>
        <div class="error">
            <ul><?php foreach ($errors as $err): ?><li><?php echo htmlspecialchars($err); ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="post" enctype="multipart/form-data">
        <label>Bio: <textarea name="bio"><?php echo htmlspecialchars($bio); ?></textarea></label>
        <label>Avatar: <input type="file" name="avatar"></label>
        <input type="submit" value="Update">
    </form>
    <a href="logout.php">Logout</a>
</body>
</html>
