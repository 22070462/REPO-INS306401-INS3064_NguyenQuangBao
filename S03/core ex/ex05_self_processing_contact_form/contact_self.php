<?php
$showForm = true;
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$message = $_POST['message'] ?? '';
$output = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($name) || empty($email) || empty($message)) {
        $output = "<p>Missing Data</p>";
    } else {
        $output = "<ul>";
        $output .= "<li>Full Name: " . htmlspecialchars($name) . "</li>";
        $output .= "<li>Email: " . htmlspecialchars($email) . "</li>";
        $output .= "<li>Phone Number: " . htmlspecialchars($phone) . "</li>";
        $output .= "<li>Message: " . htmlspecialchars($message) . "</li>";
        $output .= "</ul>";
        $output .= "<p>Thank You</p>";
        $showForm = false;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Self-Processing Contact Form</title>
</head>
<body>
    <?php echo $output; ?>
    <?php if ($showForm): ?>
        <form method="post">
            <label>Full Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required></label><br>
            <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required></label><br>
            <label>Phone Number: <input type="tel" name="phone" value="<?php echo htmlspecialchars($phone); ?>"></label><br>
            <label>Message: <textarea name="message" required><?php echo htmlspecialchars($message); ?></textarea></label><br>
            <input type="submit" value="Send">
        </form>
    <?php endif; ?>
</body>
</html>
