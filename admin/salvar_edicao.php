<?php
session_start();
if (!isset($_SESSION['adm'])) exit("Sem permissão");

$produtosPath = "../data/produtos.json";
$produtos = json_decode(file_get_contents($produtosPath), true);

$id = $_POST["id"];

// Atualiza texto
$produtos[$id]["titulo"] = $_POST["titulo"];
$produtos[$id]["descricao"] = $_POST["descricao"];
$produtos[$id]["preco"] = $_POST["preco"];

// Se o admin enviou nova imagem
if (!empty($_FILES["imagem"]["name"])) {

    // Apagar imagem antiga
    $caminhoAntigo = "../" . $produtos[$id]["imagem"];
    if (file_exists($caminhoAntigo)) {
        unlink($caminhoAntigo);
    }

    // Salvar nova
    $nomeNovo = time() . "_" . $_FILES["imagem"]["name"];
    $destino = "../img/produtos/" . $nomeNovo;

    move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino);

    // Atualizar JSON
    $produtos[$id]["imagem"] = "img/produtos/" . $nomeNovo;
}

// Salvar JSON atualizado
file_put_contents($produtosPath, json_encode($produtos, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

header("Location: index.php");
exit;
