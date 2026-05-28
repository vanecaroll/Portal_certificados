<?php

require_once 'config/conexao.php';

$mensagem = '';
$tipo = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    // criptografa a senha
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $tipo_usuario = $_POST['tipo'];

    // verifica se o email já existe
    $check = $pdo->prepare("
        SELECT id 
        FROM usuarios 
        WHERE email = :email
    ");

    $check->execute([
        ':email' => $email
    ]);

    if($check->rowCount() > 0){

        $mensagem = "Este e-mail já está cadastrado.";
        $tipo = "danger";

    } else {

        // cadastra usuário
        $sql = "INSERT INTO usuarios
        (nome, email, senha, tipo)
        VALUES
        (:nome, :email, :senha, :tipo)";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha' => $senha,
            ':tipo' => $tipo_usuario
        ]);

        $mensagem = "Conta criada com sucesso!";
        $tipo = "success";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Cadastro</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        body{

            height:100vh;

            display:flex;
            justify-content:center;
            align-items:center;

            background:
            linear-gradient(rgba(0,40,120,0.85), rgba(0,20,80,0.92)),
            url('https://www.luciloavila.com.br/wp-content/uploads/2022/09/ETE-LAP.jpg');

            background-size:cover;
            background-position:center;

            font-family:Arial;
        }

        .register-card{

            width:100%;
            max-width:500px;

            background:white;

            border-radius:25px;

            padding:40px;

            box-shadow:0 10px 40px rgba(0,0,0,0.2);

        }

        .title{

            text-align:center;
            margin-bottom:30px;

            font-size:35px;
            font-weight:bold;

            color:#08255c;

        }

        .form-control,
        .form-select{

            height:50px;
            border-radius:12px;

        }

        .btn-register{

            height:50px;

            border-radius:12px;

            font-size:16px;
            font-weight:bold;

        }

        .link-login{

            text-align:center;
            margin-top:20px;

        }

    </style>

</head>

<body>

<div class="register-card">

    <h2 class="title">

        <i class="bi bi-person-plus-fill"></i>

        Cadastro

    </h2>

    <?php if($mensagem != ''): ?>

        <div class="alert alert-<?= $tipo; ?>">

            <?= $mensagem; ?>

        </div>

    <?php endif; ?>

    <form method="POST">

        <div class="mb-3">

            <label>Nome Completo</label>

            <input
                type="text"
                name="nome"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label>Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                required
            >

        </div>

        <div class="mb-3">

            <label>Senha</label>

            <input
                type="password"
                name="senha"
                class="form-control"
                required
            >

        </div>

        <div class="mb-4">

            <label>Tipo de Conta</label>

            <select
                name="tipo"
                class="form-select"
                required
            >

                <option value="aluno">
                    Aluno
                </option>

                <option value="admin">
                    Admin
                </option>

            </select>

        </div>

        <button class="btn btn-primary w-100 btn-register">

            <i class="bi bi-check-circle"></i>

            Criar Conta

        </button>

    </form>

    <div class="link-login">

        Já possui conta?

        <a href="login.php">
            Fazer login
        </a>

    </div>

</div>

</body>
</html>