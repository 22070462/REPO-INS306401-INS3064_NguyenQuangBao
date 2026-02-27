<?php
$method = $_REQUEST['method'] ?? 'post';
$dataArray = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'GET') {
    $dataArray = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Method Toggle</title>
</head>
<body>
    <form id="form" method="post">
        <label>Data: <input type="text" name="data" required></label><br>
        <label><input type="radio" name="method" value="post" <?php if ($method === 'post') echo 'checked'; ?>> POST</label>
        <label><input type="radio" name="method" value="get"> GET</label><br>
        <input type="submit" value="Send">
    </form>
    <?php if (!empty($dataArray)): ?>
        <pre><?php print_r($dataArray); ?></pre>
    <?php endif; ?>
    <script>
        document.querySelectorAll('input[name="method"]').forEach(radio => {
            radio.addEventListener('change', () => {
                document.getElementById('form').method = radio.value;
            });
        });
    </script>
</body>
</html>
