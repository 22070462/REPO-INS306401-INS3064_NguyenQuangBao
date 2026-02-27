<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($name) || empty($email) || empty($message)) {
        echo "<p>Missing Data</p>";
    } else {
        echo "<ul>";
        echo "<li>Full Name: " . htmlspecialchars($name) . "</li>";
        echo "<li>Email: " . htmlspecialchars($email) . "</li>";
        echo "<li>Phone Number: " . htmlspecialchars($phone) . "</li>";
        echo "<li>Message: " . htmlspecialchars($message) . "</li>";
        echo "</ul>";
    }
}
?>
