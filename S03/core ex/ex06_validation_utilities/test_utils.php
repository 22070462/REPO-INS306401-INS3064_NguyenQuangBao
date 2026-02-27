<?php
require_once 'utils.php';

$tests = [
    'sanitize' => [' input <script> ', 'input &lt;script&gt;'],
    'validateEmail' => ['test@example.com', true],
    'validateLength' => ['hello', true], // min 3, max 10
    'validatePassword' => ['Pass123!', true]
];

echo "<pre>";
foreach ($tests as $func => $test) {
    if ($func === 'sanitize') {
        echo "$func: " . ($sanitize($test[0]) === $test[1] ? 'Pass' : 'Fail') . "\n";
    } elseif ($func === 'validateEmail') {
        echo "$func: " . (validateEmail($test[0]) === $test[1] ? 'Pass' : 'Fail') . "\n";
    } elseif ($func === 'validateLength') {
        echo "$func (min3 max10): " . (validateLength($test[0], 3, 10) === $test[1] ? 'Pass' : 'Fail') . "\n";
    } elseif ($func === 'validatePassword') {
        echo "$func: " . (validatePassword($test[0]) === $test[1] ? 'Pass' : 'Fail') . "\n";
    }
}
echo "</pre>";
?>
