<?php
$errors = [];
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
        $errors[] = "Invalid username (alphanumeric only)";
    }
    if (!preg_match('/[A-Z]/', $password)) $errors[] = "Password missing uppercase";
    if (!preg_match('/[a-z]/', $password)) $errors[] = "Password missing lowercase";
    if (!preg_match('/\d/', $password)) $errors[] = "Password missing number";
    if (!preg_match('/\W/', $password)) $errors[] = "Password missing symbol";
    if (empty($errors)) {
        echo "<p>Registration successful</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regex Form</title>
</head>
<body>
    <?php if ($errors): ?>
        <ul style="color:red;"><?php foreach ($errors as $err): ?><li><?php echo htmlspecialchars($err); ?></li><?php endforeach; ?></ul>
    <?php endif; ?>
    <form method="post">
        <label>Username: <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>" required></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
