<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
    <a href="profile.php">Edit Profile</a><br>
    <a href="logout.php">Logout</a>
</body>
</html>
