<?php
// file: Validator.php

function validateAge($age) {
    if (!is_numeric($age)) {
        throw new InvalidArgumentException("Umur harus berupa angka");
    }
    if ($age < 0 ) {
        throw new InvalidArgumentException("Umur tidak boleh negatif");
    }
    return true;
}

function validateName($name) {

    // Nama tidak boleh kosong
    if (trim($name) === '') {
        throw new InvalidArgumentException("Nama mahasiswa tidak boleh kosong");
    }

    // Nama harus berupa huruf
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        throw new InvalidArgumentException("Nama mahasiswa harus berupa huruf");
    }

    return true;
}