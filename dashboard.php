<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nome = $_SESSION['usuario_nome'];

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-5">

        <h1 class="mb-4">
            Bem-vindo,
            <?php echo $_SESSION['usuario_nome']; ?>
        </h1>

        <a href="enviar_atividade.php" class="btn btn-success mb-3">
    Enviar Atividade
</a>

<a href="meus_certificados.php"
class="btn btn-success">

    Meus Certificados

</a>

        <a href="logout.php" class="btn btn-danger">
            Sair
        </a>

    </div>

</div>

</body>
</html>