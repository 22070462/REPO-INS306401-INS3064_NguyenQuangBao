<?php
function sanitize(string $data): string {
    return htmlspecialchars(stripslashes(trim($data)), ENT_QUOTES, 'UTF-8');
}

function validateEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateLength(string $str, int $min, int $max): bool {
    $len = strlen($str);
    return $len >= $min && $len <= $max;
}

function validatePassword(string $pass): bool {
    // At least 8 chars, 1 upper, 1 lower, 1 num, 1 special
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $pass);
}
?>
