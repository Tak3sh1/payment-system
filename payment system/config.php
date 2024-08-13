<?php
// Configuração e conexão com o banco de dados
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

// Definindo a consulta SQL
$sql = 'SELECT * FROM tb_beneficiario'; // Nome da tabela para a consulta

try {
    $consulta = $pdo->query($sql); // Executa a consulta e retorna um PDOStatement
} catch (PDOException $e) {
    echo 'Erro na consulta: ' . $e->getMessage();
    exit();
}
?>
