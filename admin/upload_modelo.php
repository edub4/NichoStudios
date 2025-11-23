<?php
session_start();
if (!isset($_SESSION['adm'])) exit("Sem permissão");

// Pasta onde as fotos ficam
$targetDir = "../img/modelos/";

// ID do modelo escolhido
$id = $_POST['id'];

// Verifica se veio imagem
if (!isset($_FILES['imagem']) || $_FILES['imagem']['error'] != 0) {
    exit("Erro: Nenhuma imagem enviada.");
}

// pega extensão real (.jpg, .png, .jpeg, etc)
$extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));

// Gera nome padronizado
$novoNome = "foto{$id}md." . $extensao;

// Carrega JSON
$jsonPath = "../data/modelos.json";
$modelos = json_decode(file_get_contents($jsonPath), true);

// Se existir uma imagem antiga, apaga
if (isset($modelos[$id])) {
    $caminhoAntigo = "../" . $modelos[$id];
    if (file_exists($caminhoAntigo)) {
        unlink($caminhoAntigo);
    }
}

// Move nova imagem para a pasta
move_uploaded_file($_FILES['imagem']['tmp_name'], $targetDir . $novoNome);

// Atualiza JSON
$modelos[$id] = "img/modelos/" . $novoNome;

file_put_contents($jsonPath, json_encode($modelos, JSON_PRETTY_PRINT));

// Volta para o painel
header("Location: index.php");
exit();