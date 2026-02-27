<?php
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($name)) $errors['name'] = "Name required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email";
    if (empty($errors)) {
        echo "<p>Form submitted</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error Summary</title>
    <style>.error { border: 1px solid red; } .alert { color: red; }</style>
</head>
<body>
    <?php if ($errors): ?>
        <div class="alert">
            <ul><?php foreach ($errors as $err): ?><li><?php echo htmlspecialchars($err); ?></li><?php endforeach; ?></ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" class="<?php echo isset($errors['name']) ? 'error' : ''; ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" class="<?php echo isset($errors['email']) ? 'error' : ''; ?>" required></label><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
