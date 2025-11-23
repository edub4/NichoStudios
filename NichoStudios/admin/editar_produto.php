<?php
session_start();
if (!isset($_SESSION['adm'])) exit("Sem permissão");

$produtos = json_decode(file_get_contents("../data/produtos.json"), true);

$id = $_GET["id"];
$produto = $produtos[$id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN NichoStudios</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>
    
<h2>Editar Produto</h2>

<form action="salvar_edicao.php" method="POST" enctype="multipart/form-data" id="editarproduto">
    <input type="hidden" name="id" value="<?= $id ?>">

    <input type="text" name="titulo" value="<?= $produto['titulo'] ?>"><br><br>
    <input type="text" name="descricao" value="<?= $produto['descricao'] ?>"><br><br>
    <input type="number" name="preco" step="0.01" value="<?= $produto['preco'] ?>"><br><br>

    <p>Imagem atual:</p>
    <img src="../<?= $produto['imagem'] ?>" width="120"><br><br>

    <p>Nova imagem (opcional):</p>
    <input type="file" name="imagem" id="editarImagem" onchange="previewEdicao()"><br><br>

    <img id="previewEdicaoImg" style="display:none; width:120px; margin-top:10px;">

    <button type="submit" >Salvar Alterações</button>
    
</form>

<script>
function previewEdicao() {
    let input = document.getElementById("editarImagem");
    let preview = document.getElementById("previewEdicaoImg");
    let arquivo = input.files[0];

    if (arquivo) {
        preview.style.display = "block";
        preview.src = URL.createObjectURL(arquivo);
    }
}
</script>

</body>
</html>