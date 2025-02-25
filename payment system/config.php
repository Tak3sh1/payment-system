<?php
$dsn = 'mysql:host=localhost;dbname=bd_pagamentoo';
$usuario = 'root';
$senha = 'root';

try {
    $pdo = new PDO($dsn, $usuario, $senha);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Conexão falhou: ' . $e->getMessage();
    exit();
}

$sql = 'SELECT * FROM tb_beneficiario'; 

try {
    $consulta = $pdo->query($sql); 
} catch (PDOException $e) {
    echo 'Erro na consulta: ' . $e->getMessage();
    exit();
}
?>
