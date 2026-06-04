<?php

$host = "127.0.0.1";
$db = "sistema_arquivos";
$user = "root";
$pass = "";
$porta = "3306";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$porta;dbname=$db;charset=utf8",
        $user,
        $pass
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}

?>