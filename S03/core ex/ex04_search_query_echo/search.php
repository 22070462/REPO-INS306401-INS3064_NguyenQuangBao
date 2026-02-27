<?php
$q = $_GET['q'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search</title>
</head>
<body>
    <form method="get">
        <label>Search: <input type="text" name="q" value="<?php echo htmlspecialchars($q); ?>"></label>
        <input type="submit" value="Search">
    </form>
    <?php if ($q): ?>
        <p>Search term: <?php echo htmlspecialchars($q); ?></p>
    <?php endif; ?>
</body>
</html>
