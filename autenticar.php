<?php

session_start();

require_once 'config/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM usuarios WHERE email = :email";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':email' => $email
]);

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if($usuario){

    if(password_verify($senha, $usuario['senha'])){
        
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario_nome'] = $usuario['nome'];
    $_SESSION['tipo'] = $usuario['tipo'];

// verifica se é admin ou aluno
if($usuario['tipo'] == 'admin'){

    header("Location: admin_certificados.php");

} else {

    header("Location: dashboard.php");

}

exit;

    } else {

        echo "Senha incorreta";

    }

} else {

    echo "Usuário não encontrado";

}
?>