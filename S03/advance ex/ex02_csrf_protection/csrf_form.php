<?php
session_start();
$token = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $token;
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("403 Forbidden");
    }
    $data = $_POST['data'] ?? '';
    $message = "Data received: " . htmlspecialchars($data);
    unset($_SESSION['csrf_token']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CSRF Form</title>
</head>
<body>
    <form method="post">
        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        <label>Data: <input type="text" name="data" required></label><br>
        <input type="submit" value="Submit">
    </form>
    <?php if ($message): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>
