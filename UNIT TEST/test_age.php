<?php
// file test_age.php
require_once 'Validator.php';

//test case 1 : umur valid
try {
    validateAge(25);
    echo "PASS : umur 25 diterima\n";
} catch (Exception $e) {
    echo "FAIL : umur 25 tidak di terima. Eror: " . $e->getMessage() . "\n";
}

try {
    $result = validateAge(-5);
    echo "PASS : umur -5 diterima\n";
} catch (Exception $e) {
    echo "FAIL : umur -5 tidak di terima. Eror: " . $e->getMessage() . "\n";
}