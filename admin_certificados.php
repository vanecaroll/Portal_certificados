<?php

session_start();

require_once 'config/conexao.php';

$sql = "
SELECT
    atividades.*,
    usuarios.nome
FROM atividades
INNER JOIN usuarios
ON atividades.usuario_id = usuarios.id
ORDER BY curso, turma
";

$stmt = $pdo->query($sql);

$atividades = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Certificados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow p-4">

        <h2 class="mb-4">Certificados Enviados</h2>

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th>Aluno</th>
                    <th>Curso</th>
                    <th>Turma</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Link</th>
                    <th>Arquivo</th>
                </tr>
            </thead>

            <tbody>

                <?php foreach($atividades as $atividade): ?>

                <tr>

                    <td><?= $atividade['nome'] ?></td>

                    <td><?= $atividade['curso'] ?></td>

                    <td><?= $atividade['turma'] ?></td>

                    <td><?= $atividade['titulo'] ?></td>

                    <td><?= $atividade['descricao'] ?></td>

                    <td>
                        <a href="<?= $atividade['link_atividade'] ?>" target="_blank">
                            Abrir
                        </a>
                    </td>

                    <td>
                        <a href="uploads/<?= $atividade['arquivo'] ?>" target="_blank">
                            Ver Arquivo
                        </a>
                    </td>

                </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>