<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

require_once '../includes/utils.php';

$username = $_POST['username'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';

    $users = getUsers();
    foreach ($users as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            $_SESSION['user'] = $username;
            header('Location: profile.php');
            exit;
        }
    }
    $errors[] = "Invalid credentials";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php if ($errors): ?>
        <div class="error">
            <ul><?php foreach ($errors as $err): ?><li><?php echo htmlspecialchars($err); ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <label>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <input type="submit" value="Login">
    </form>
</body>
</html>
