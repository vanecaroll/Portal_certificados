<?php

require_once 'config/conexao.php';

$mensagem = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $email = $_POST['email'];

    // nova senha criptografada
    $nova_senha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);

    $sql = "UPDATE usuarios
            SET senha = :senha
            WHERE email = :email";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':senha' => $nova_senha,
        ':email' => $email
    ]);

    if($stmt->rowCount() > 0){

        $mensagem = "Senha alterada com sucesso!";

    } else {

        $mensagem = "E-mail não encontrado.";

    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <title>Recuperar Senha</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card p-4 shadow mx-auto" style="max-width:500px;">

        <h2 class="text-center mb-4">
            Recuperar Senha
        </h2>

        <?php if($mensagem != ''): ?>

            <div class="alert alert-info">

                <?= $mensagem; ?>

            </div>

        <?php endif; ?>

        <form method="POST">

            <div class="mb-3">

                <label>E-mail</label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required
                >

            </div>

            <div class="mb-3">

                <label>Nova Senha</label>

                <input
                    type="password"
                    name="nova_senha"
                    class="form-control"
                    required
                >

            </div>

            <button class="btn btn-primary w-100">

                Alterar Senha

            </button>

        </form>

        <div class="text-center mt-3">

            <a href="login.php">
                Voltar ao login
            </a>

        </div>

    </div>

</div>

</body>
</html>