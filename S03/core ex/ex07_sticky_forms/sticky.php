<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$pass = $_POST['pass'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (strlen($pass) < 8) {
        $errors[] = "Password too short";
    }
    if (empty($name) || empty($email)) {
        $errors[] = "Missing fields";
    }
    if (empty($errors)) {
        echo "<p>Form submitted successfully</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sticky Form</title>
</head>
<body>
    <?php if ($errors): ?>
        <ul style="color:red;"><?php foreach ($errors as $err): ?><li><?php echo htmlspecialchars($err); ?></li><?php endforeach; ?></ul>
    <?php endif; ?>
    <form method="post">
        <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required></label><br>
        <label>Password: <input type="password" name="pass" value="<?php echo htmlspecialchars($pass); ?>" required></label><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
