<?php
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$bio = $_POST['bio'] ?? '';
$location = $_POST['location'] ?? '';
$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($bio) && !empty($location)) {
    $output = "<ul>";
    $output .= "<li>Username: " . htmlspecialchars($username) . "</li>";
    $output .= "<li>Password: [hidden]</li>";
    $output .= "<li>Bio: " . htmlspecialchars($bio) . "</li>";
    $output .= "<li>Location: " . htmlspecialchars($location) . "</li>";
    $output .= "</ul>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Step 2: Profile Info</title>
</head>
<body>
    <?php echo $output; ?>
    <?php if (empty($output)): ?>
        <form method="post">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <label>Bio: <textarea name="bio" required></textarea></label><br>
            <label>Location: <input type="text" name="location" required></label><br>
            <input type="submit" value="Submit">
        </form>
    <?php endif; ?>
</body>
</html>
