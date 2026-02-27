<?php
session_start();
if (isset($_SESSION['user'])) {
    header('Location: profile.php');
    exit;
}

require_once '../includes/utils.php';

$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($password !== $confirm) $errors[] = "Passwords do not match";
    if (!validateEmail($email)) $errors[] = "Invalid email";
    if (!validatePassword($password)) $errors[] = "Password must have at least 8 chars, 1 upper, 1 lower, 1 num, 1 special";
    
    $users = getUsers();
    foreach ($users as $user) {
        if ($user['username'] === $username || $user['email'] === $email) {
            $errors[] = "Username or email already exists";
            break;
        }
    }

    if (empty($errors)) {
        $users[] = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'bio' => '',
            'avatar' => ''
        ];
        saveUsers($users);
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
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
        <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <label>Confirm Password: <input type="password" name="confirm" required></label>
        <input type="submit" value="Register">
    </form>
</body>
</html>
