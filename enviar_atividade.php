<?php
session_start();

if(!isset($_SESSION['usuario_id'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Enviar Atividade</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-5">

        <h2 class="mb-4">Enviar Atividade</h2>

        <form action="upload.php" method="POST" enctype="multipart/form-data">

    <div class="mb-3">
        <label class="form-label">Curso</label>

        <input
            type="text"
            name="curso"
            class="form-control"
            placeholder="Digite seu curso"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Turma</label>

        <input
            type="text"
            name="turma"
            class="form-control"
            placeholder="Digite sua turma"
            required
        >
    </div>

    <div class="mb-3">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="descricao" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Link da atividade</label>
        <input type="url" name="link" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Selecionar Arquivo</label>
        <input type="file" name="arquivo" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary">
        Enviar Arquivo
    </button>

</form>

    </div>

</div>

</body>
</html>