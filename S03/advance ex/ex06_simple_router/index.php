<?php
$page = $_GET['page'] ?? 'home';
$allowedPages = ['home', 'contact', 'about'];

if (in_array($page, $allowedPages)) {
    include "pages/$page.php";
} else {
    echo "<h1>Page Not Found</h1>";
}
?>
