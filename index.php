<?php

require_once 'config/conexao.php';

if(!isset($_SESSION['usuario_id'])){

    header("Location: login.php");
    exit;
}

$mensagem = '';
$tipo_mensagem = '';

// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_nome   = filter_input(INPUT_POST, 'aluno_nome', FILTER_SANITIZE_SPECIAL_CHARS);
    $descricao    = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
    $link_externo = filter_input(INPUT_POST, 'link_externo', FILTER_VALIDATE_URL);
    
    $arquivo_path = null;

    // Verifica se um arquivo foi enviado
    if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
        $diretorio_destino = 'uploads/';
        
        // Cria a pasta se ela não existir
        if (!is_dir($diretorio_destino)) {
            mkdir($diretorio_destino, 0755, true);
        }

        $nome_original = $_FILES['arquivo']['name'];
        $extensao = pathinfo($nome_original, PATHINFO_EXTENSION);
        
        // Gera um nome único para o arquivo para evitar sobrescritas
        $novo_nome = uniqid('atv_', true) . '.' . $extensao;
        $caminho_final = $diretorio_destino . $novo_nome;

        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $caminho_final)) {
            $arquivo_path = $caminho_final;
        } else {
            $mensagem = "Erro ao mover o arquivo para o servidor.";
            $tipo_mensagem = "danger";
        }
    }

    // Se não houver erros até aqui, salva no banco de dados
    if ($tipo_mensagem !== 'danger') {
        try {
            $sql = "INSERT INTO atividades (aluno_nome, descricao, link_externo, arquivo_path) 
                    VALUES (:aluno_nome, :descricao, :link_externo, :arquivo_path)";
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':aluno_nome'   => $aluno_nome,
                ':descricao'    => $descricao,
                ':link_externo' => $link_externo ? $link_externo : null,
                ':arquivo_path' => $arquivo_path
            ]);

            $mensagem = "Atividade enviada com sucesso!";
            $tipo_mensagem = "success";
        } catch (Exception $e) {
            $mensagem = "Erro ao salvar no banco: " . $e->getMessage();
            $tipo_mensagem = "danger";
        }
    }
}

// Busca as atividades já enviadas para listar na tela
$atividades = $pdo->query("SELECT * FROM atividades ORDER BY data_envio DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controle de Atividades Acadêmicas</title>
    <!-- Bootstrap 5 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            
            <div class="d-flex justify-content-between align-items-center mb-4">

    <h2>Portal de Entrega de Atividades</h2>

    <div>

        <span class="me-3">
            <?= $_SESSION['usuario_nome']; ?>
        </span>

        <a href="logout.php" class="btn btn-danger btn-sm">
            Sair
        </a>

    </div>

</div>

            <!-- Alertas de Feedback -->
            <?php if (!empty($mensagem)): ?>
                <div class="alert alert-<?= $tipo_mensagem; ?> alert-dismissible fade show" role="alert">
                    <?= $mensagem; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Formulário de Envio -->
            <div class="card shadow-sm mb-5">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Enviar Nova Atividade</h5>
                </div>
                <div class="card-body">
                    <!-- O enctype é OBRIGATÓRIO para envio de arquivos -->
                    <form action="index.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="mb-3">
                            <label for="aluno_nome" class="form-label">Nome Completo do Aluno</label>
                            <input type="text" class="form-control" id="aluno_nome" name="aluno_nome" required placeholder="Digite seu nome">
                        </div>

                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição da Atividade</label>
                            <textarea class="form-control" id="descricao" name="descricao" rows="3" placeholder="Explique brevemente o que está entregando..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="link_externo" class="form-label">Link Externo (GitHub, Notion, etc.)</label>
                                <input type="url" class="form-control" id="link_externo" name="link_externo" placeholder="https://exemplo.com">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="arquivo" class="form-label">Upload do Arquivo (PDF, ZIP, DOCX)</label>
                                <input class="form-control" type="file" id="arquivo" name="arquivo">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-success px-4">Entregar Atividade</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tabela de Atividades Entregues -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Atividades Registradas</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Aluno</th>
                                    <th>Descrição</th>
                                    <th>Links / Arquivos</th>
                                    <th>Data de Envio</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($atividades) > 0): ?>
                                    <?php foreach ($atividades as $atv): ?>
                                        <tr>
                                            <td class="fw-bold"><?= htmlspecialchars($atv['aluno_nome']); ?></td>
                                            <td><?= nl2br(htmlspecialchars($atv['descricao'])); ?></td>
                                            <td>
                                                <?php if ($atv['link_externo']): ?>
                                                    <a href="<?= htmlspecialchars($atv['link_externo']); ?>" target="_blank" class="btn btn-sm btn-outline-primary me-1 mb-1">
                                                        Acessar Link
                                                    </a>
                                                <?php endif; ?>

                                                <?php if ($atv['arquivo_path']): ?>
                                                    <a href="<?= htmlspecialchars($atv['arquivo_path']); ?>" download class="btn btn-sm btn-outline-success mb-1">
                                                        Baixar Arquivo
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted d-block small">Nenhum arquivo enviado</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= date('d/m/Y H:i', strtotime($atv['data_envio'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Nenhuma atividade entregue ainda.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS Bundle com Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

