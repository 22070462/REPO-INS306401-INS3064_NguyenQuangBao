<?php
$result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $num1 = $_POST['num1'] ?? '';
    $num2 = $_POST['num2'] ?? '';
    $op = $_POST['op'] ?? '';

    if (is_numeric($num1) && is_numeric($num2) && !empty($op)) {
        if ($op === '/' && $num2 == 0) {
            $result = "Division by zero error";
        } else {
            $calc = match ($op) {
                '+' => $num1 + $num2,
                '-' => $num1 - $num2,
                '*' => $num1 * $num2,
                '/' => $num1 / $num2,
            };
            $result = htmlspecialchars("$num1 $op $num2 = $calc");
        }
    } else {
        $result = "Invalid inputs";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
</head>
<body>
    <form method="post">
        <input type="number" name="num1" required>
        <select name="op" required>
            <option value="+">+</option>
            <option value="-">-</option>
            <option value="*">*</option>
            <option value="/">/</option>
        </select>
        <input type="number" name="num2" required>
        <input type="submit" value="Calculate">
    </form>
    <?php if ($result): ?>
        <p><?php echo $result; ?></p>
    <?php endif; ?>
</body>
</html>
