<?php
session_start();
if (!isset($_SESSION['adm'])) exit("Sem permissão");

$produtosPath = "../data/produtos.json";
$produtos = json_decode(file_get_contents($produtosPath), true);

// salvar imagem
$target = "../img/produtos/";
$nomeImagem = time() . ".png"; 
move_uploaded_file($_FILES['imagem']['tmp_name'], $target . $nomeImagem);

// criar produto
$novo = [
    "titulo" => $_POST["titulo"],
    "descricao" => $_POST["descricao"],
    "preco" => floatval($_POST["preco"]),
    "imagem" => "img/produtos/" . $nomeImagem
];

$produtos[] = $novo;

file_put_contents($produtosPath, json_encode($produtos, JSON_PRETTY_PRINT));

header("Location: index.php");