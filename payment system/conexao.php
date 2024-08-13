<?php
$host = 'localhost';
$dbname = 'bd_pagamentoo';
$username = 'root';
$password = 'root';

try {
    $PDO = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro ao conectar ao banco de dados: ' . $e->getMessage();
    exit;
}
?>
