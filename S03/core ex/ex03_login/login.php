<?php
$attempts = (int)($_POST['attempts'] ?? 0);
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';
    $attempts++;

    if ($user === 'admin' && $pass === '123456') {
        $message = "Login Successful";
    } else {
        $message = "Invalid Credentials. Failed Attempts: $attempts";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form method="post">
        <label>Username: <input type="text" name="user" required></label><br>
        <label>Password: <input type="password" name="pass" required></label><br>
        <input type="hidden" name="attempts" value="<?php echo $attempts; ?>">
        <input type="submit" value="Login">
    </form>
    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
</body>
</html>
