<?php

session_start();
require_once 'config/conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$titulo = $_POST['titulo'];
$descricao = $_POST['descricao'];
$link = $_POST['link'];

$curso = $_POST['curso'];
$turma = $_POST['turma'];

$arquivo = $_FILES['arquivo'];

$nomeArquivo = time() . "_" . $arquivo['name'];

$tmp = $arquivo['tmp_name'];

/*
|--------------------------------------------------------------------------
| CRIA A PASTA DA TURMA SE NÃO EXISTIR
|--------------------------------------------------------------------------
*/

$pasta = "uploads/" . $turma . "/";

if(!is_dir($pasta)){
    mkdir($pasta, 0777, true);
}

/*
|--------------------------------------------------------------------------
| CAMINHO COMPLETO DO ARQUIVO
|--------------------------------------------------------------------------
*/

$destino = $pasta . $nomeArquivo;

/*
|--------------------------------------------------------------------------
| MOVE O ARQUIVO
|--------------------------------------------------------------------------
*/

move_uploaded_file($tmp, $destino);

/*
|--------------------------------------------------------------------------
| SALVA NO BANCO
|--------------------------------------------------------------------------
*/

$sql = "INSERT INTO atividades
(usuario_id, titulo, descricao, link_atividade, arquivo, curso, turma)
VALUES
(:usuario_id, :titulo, :descricao, :link, :arquivo, :curso, :turma)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':usuario_id' => $usuario_id,
    ':titulo' => $titulo,
    ':descricao' => $descricao,
    ':link' => $link,
    ':arquivo' => $destino,
    ':curso' => $curso,
    ':turma' => $turma
]);

echo "Atividade enviada com sucesso!";
?>