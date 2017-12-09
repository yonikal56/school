<?php

function generate_salt($length){
    $base = 'abcdefghijklmnopqrstvuwxyzABCDEFGHIJKLMNOPQRSTVUWXYZ1234567890!@#$%^&*()_+{}][';
    $shuffeled_base = str_shuffle($base);
    $start = rand(0, 10);
    return substr($shuffeled_base, $start, $length);
}

function encrypt_password($password, $salt) {
    $encryped_pass = sha1($salt . sha1($salt) . $password);
    $encryped_pass = hash('sha256', sha1($salt) . hash('sha256', $password . $salt) . $encryped_pass);
    $encryped_pass = sha1($encryped_pass . sha1($salt . $password . $salt));
    return $encryped_pass;
}