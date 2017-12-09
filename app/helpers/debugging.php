<?php

function die_r($value){
    echo '<pre>';
        print_r($value);
    echo '</pre>';
    die();
}

function var_die($value){
    echo '<pre>';
        var_dump($value);
    echo '</pre>';
    die();
}