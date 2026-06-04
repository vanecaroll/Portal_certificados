<?php

// inicia sessão
session_start();


// conexão com banco
require_once 'config/conexao.php';


// verifica se usuário está logado
if(!isset($_SESSION['usuario_id'])){

    header("Location: login.php");
    exit;
}


// pega ID do usuário logado
$usuario_id = $_SESSION['usuario_id'];


// busca apenas atividades do usuário logado
$sql = "SELECT * FROM atividades
        WHERE usuario_id = :usuario_id
        ORDER BY id DESC";

$stmt = $pdo->prepare($sql);


// executa consulta
$stmt->execute([
    ':usuario_id' => $usuario_id
]);


// pega resultados
$atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Meus Certificados</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">

        Meus Certificados

    </h2>


    <!-- verifica se existem certificados -->
    <?php if(count($atividades) > 0): ?>

        <!-- percorre atividades -->
        <?php foreach($atividades as $atividade): ?>

            <div class="card shadow p-4 mb-3">

                <h4>

                    <?= $atividade['titulo']; ?>

                </h4>

                <p>

                    <?= $atividade['descricao']; ?>

                </p>

                <p>

                    <strong>Curso:</strong>

                    <?= $atividade['curso']; ?>

                </p>

                <p>

                    <strong>Turma:</strong>

                    <?= $atividade['turma']; ?>

                </p>

                <a
                    href="/Portal_certificados/<?= $atividade['arquivo']; ?>"
                    target="_blank"
                    class="btn btn-primary"
                >

                    Ver Certificado

                </a>

            </div>

        <?php endforeach; ?>

    <?php else: ?>

        <div class="alert alert-info">

            Você ainda não enviou certificados.

        </div>

    <?php endif; ?>

</div>

</body>
</html>