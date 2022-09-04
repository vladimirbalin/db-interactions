<?php

try{
    $connect = mysqli_connect('localhost', 'root', 'root', 'blogdb', 3306);
} catch (mysqli_sql_exception $e){
    echo $e->getMessage();
    die();
}