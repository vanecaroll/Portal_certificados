<?php
require_once 'config/conexao.php';

if(isset($_SESSION['usuario_id'])){
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portal de Atividades</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            height:100vh;
            overflow:hidden;
            font-family:Arial, sans-serif;
        }

        .container-login{
            width:100%;
            height:100vh;
            display:flex;
        }

        /* ==========================================================================
           ESQUERDA - AJUSTE PERFEITO DO BANNER VERTICAL DA ETE
           ========================================================================== */
        .left-side{
            width:45%;
            height:100%;
            position:relative;

            /* Cor de fundo de segurança caso a imagem demore a carregar */
            background-color: #06193f;
            
            /* Caminho do arquivo do seu banner */
            background-image: url('banner_ete.jpg'); 
            
            /* 'cover' faz o banner preencher todo o espaço vertical como na foto */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;

            display:flex;
            justify-content:center;
            align-items:center;
            
            /* Mantém o corte diagonal moderno na junção das telas */
            clip-path: polygon(0 0, 88% 0, 100% 100%, 0% 100%);
        }

        /* Container de conteúdo vazio ou para textos adicionais discretos no futuro */
        .overlay-content{
            text-align:center;
            color:white;
            padding:40px;
        }

        /* ==========================================================================
           DIREITA - CARD DE LOGIN
           ========================================================================== */
        .right-side{
            width:55%;
            height:100%;
            background:#f4f6fb;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-card{
            width:100%;
            max-width:450px;
            background:white;
            border-radius:24px;
            padding:45px;
            box-shadow:0 10px 40px rgba(0,0,0,0.1);
            animation:fade .5s ease;
        }

        .icon-top{
            width:75px;
            height:75px;
            margin:auto;
            margin-bottom:25px;
            border-radius:18px;
            background:#eef3ff;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:35px;
            color:#0d6efd;
        }

        .title{
            text-align:center;
            font-size:40px;
            font-weight:bold;
            color:#08255c;
            margin-bottom:10px;
        }

        .subtitle{
            text-align:center;
            color:#666;
            margin-bottom:35px;
        }

        .form-label{
            font-weight:600;
            color:#333;
        }

        .form-control{
            height:52px;
            border-radius:12px;
        }

        .input-group-text{
            border-radius:12px 0 0 12px;
        }

        .btn-login{
            height:52px;
            border-radius:12px;
            font-size:16px;
            font-weight:bold;
            margin-top:10px;
        }

        .btn-register{
            height:52px;
            border-radius:12px;
            font-size:16px;
            font-weight:bold;
            margin-top:15px;
            background:#08255c;
            border:none;
        }

        .footer{
            text-align:center;
            margin-top:30px;
            color:#999;
            font-size:13px;
        }

        @keyframes fade{
            from{
                opacity:0;
                transform:translateY(-20px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

        @media(max-width:992px){
            .left-side{
                display:none;
            }
            .right-side{
                width:100%;
            }
        }

    </style>

</head>

<body>

<div class="container-login">

    <div class="left-side">
        <div class="overlay-content">
            </div>
    </div>

    <div class="right-side">

        <div class="login-card">

            <div class="icon-top">
                <i class="bi bi-journal-bookmark-fill"></i>
            </div>

            <h2 class="title">
                Login
            </h2>

            <p class="subtitle">
                Faça login para acessar o sistema
            </p>

            <form action="autenticar.php" method="POST">

                <div class="mb-3">
                    <label class="form-label">Usuário</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-person"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Digite seu e-mail"
                            required
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Senha</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="senha"
                            class="form-control"
                            placeholder="Digite sua senha"
                            required
                        >
                    </div>
                </div>

                <button class="btn btn-primary w-100 btn-login">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Entrar
                </button>

            </form>

            <a href="registro.php" class="btn btn-dark w-100 btn-register">
    <i class="bi bi-person-plus-fill"></i>
    Criar Conta
</a>

<div class="text-center mt-3">

    <a href="recuperar_senha.php" class="text-decoration-none">

        <i class="bi bi-key-fill"></i>

        Esqueci minha senha

    </a>

</div>