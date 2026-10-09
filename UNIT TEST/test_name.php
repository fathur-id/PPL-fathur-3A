<?php
require_once 'validator.php';

echo "--- Pengujian ValidateName() ---\n";

try {
    ValidateName("NAMA LENGKAP ANDA"); 
    echo "PASS: Nama lengkap diterima.\n";
} catch (Exception $e) {
    echo "FAIL: " . $e->getMessage() . "\n";
}


try {
    ValidateName("NAMA LENGKAP ANDA 1212"); 
    echo "PASS (TIDAK VALID): Nama dengan angka gagal ditangkap.\n";
} catch (Exception $e) {
    echo "EXPECTED FAIL: " . $e->getMessage() . "\n";
}


try {
    ValidateName("");
    echo "PASS (TIDAK VALID): Data kosong gagal ditangkap.\n";
} catch (Exception $e) {
    echo "EXPECTED FAIL: " . $e->getMessage() . "\n";
}