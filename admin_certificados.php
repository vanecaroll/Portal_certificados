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
ORDER BY turma, nome
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

                <?php $turmaAtual = ''; ?>

                <?php foreach($atividades as $atividade): ?>

                    <?php if($turmaAtual != $atividade['turma']): ?>

                        <?php $turmaAtual = $atividade['turma']; ?>

                        <tr class="table-primary">
                            <td colspan="7">
                                <strong>
                                    <?= str_replace('_', ' ', $turmaAtual) ?>
                                </strong>
                            </td>
                        </tr>

                    <?php endif; ?>

                    <tr>

                        <td><?= htmlspecialchars($atividade['nome']) ?></td>

                        <td><?= htmlspecialchars($atividade['curso']) ?></td>

                        <td><?= htmlspecialchars($atividade['turma']) ?></td>

                        <td><?= htmlspecialchars($atividade['titulo']) ?></td>

                        <td><?= htmlspecialchars($atividade['descricao']) ?></td>

                        <td>
                            <?php if(!empty($atividade['link_atividade'])): ?>
                                <a href="<?= $atividade['link_atividade'] ?>" target="_blank">
                                    Abrir
                                </a>
                            <?php endif; ?>
                        </td>

                        <td>
                            <a href="<?= $atividade['arquivo'] ?>" target="_blank">
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