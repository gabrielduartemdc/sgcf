<?php
// conexao.php

$host = 'localhost';
$port = '5432';
$dbname = 'db_sgcf';
$user = 'root';
$password = '123456';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    error_log('Erro de conexão: ' . $e->getMessage());
    die('Não foi possível conectar ao banco de dados.');
}  