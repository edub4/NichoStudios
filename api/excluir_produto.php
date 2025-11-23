<?php
session_start();
if (!isset($_SESSION['adm'])) exit("Sem permissão");

// caminho do JSON
$produtosPath = "../data/produtos.json";

// carrega produtos e força indexação correta
$produtos = json_decode(file_get_contents($produtosPath), true);
$produtos = array_values($produtos); // <<< AQUI arruma tudo!!!

// pega ID pela URL
$id = $_GET["id"];

// verifica se existe
if (!isset($produtos[$id])) {
    exit("Produto não encontrado.");
}

// caminho da imagem antiga
$caminhoImagem = "../" . $produtos[$id]["imagem"];

// excluir imagem física
if (file_exists($caminhoImagem)) {
    unlink($caminhoImagem);
}

// remove produto
array_splice($produtos, $id, 1);

// salva novo JSON
file_put_contents($produtosPath, json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// volta ao painel
header("Location: index.php");
exit();
