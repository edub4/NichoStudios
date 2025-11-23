<?php
session_start();
if (!isset($_SESSION['adm'])) {
    header("Location: login.php");
    exit();
}
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
    
<h1>Painel ADMIN</h1>

<h2>Alterar Fotos de Modelos</h2>
    <form action="upload_modelo.php" method="POST" enctype="multipart/form-data">
    <div class="divModelo">
        <div class="imgsPreview">
            <img id="previewModelo" src="" alt="Prévia da imagem Antiga">
            <p>></p>
            <img id="previewModeloNew" src="" alt="Prévia da imagem Nova">
        </div>

        <select name="id" id="selectModelo" required>
            <option value="">Selecione um modelo</option>
            <option value="1">Modelo 1</option>
            <option value="2">Modelo 2</option>
            <option value="3">Modelo 3</option>
        </select>

        <br><br>
            <input type="file" name="imagem" id="fileModelo" required>
        <br><br>

        <button type="submit"> ENVIAR</button>
    </div>
</form>
<h2>Adicionar Produto</h2>

<form action="salvar_produto.php" method="POST" enctype="multipart/form-data" id="formADD">
    
    <input type="text" name="titulo" placeholder="Título" required>
    <input type="text" name="descricao" placeholder="Descrição" required>
    <input type="number" name="preco" step="0.01" placeholder="Preço" required>
    <input type="file" name="imagem" id="inputImagem" onchange="previewImagem()" required>
    <div class="imgProduto">
        <img id="preview" src="" alt="Preview">
    </div>
    <button type="submit">SALVAR</button>
</form>

<?php
// CARREGAR JSON CORRETAMENTE
$produtos = json_decode(file_get_contents("../data/produtos.json"), true);
?>

<h1>Lista de Produtos</h1>

<div class="lista-produtos">
<?php foreach ($produtos as $index => $p): ?>
    <div class="produto">

        <img src="../<?= $p['imagem'] ?>">

        <h3><?= $p['titulo'] ?></h3>

        <p><?= $p['descricao'] ?></p>

        <p class="preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>

        <a href="editar_produto.php?id=<?= $index ?>">Editar</a>
        <a href="excluir_produto.php?id=<?= $index ?>" 
   onclick="return confirm('Tem certeza que deseja excluir este produto?')"
   >
   Excluir
</a>

    </div>
<?php endforeach; ?>
</div>

<a href="logout.php" id="sair">Sair</a>

<script>
fetch("../data/modelos.json")
    .then(r => r.json())
    .then(modelos => {
        const preview = document.getElementById("previewModelo");
        const select = document.getElementById("selectModelo");

        select.addEventListener("change", () => {
            const id = select.value;

            if (id && modelos[id]) {

                // força pegar a imagem nova
                preview.src = "../" + modelos[id] + "?v=" + Date.now();

                preview.style.display = "block";
            } else {
                preview.style.display = "none";
            }
        });
    });



// Preview da imagem NOVA
const inputModelo = document.getElementById("fileModelo");
const previewNovo = document.getElementById("previewModeloNew");

inputModelo.addEventListener("change", () => {
    if (inputModelo.files && inputModelo.files[0]) {
        previewNovo.src = URL.createObjectURL(inputModelo.files[0]);
        previewNovo.style.display = "block";
    }
});
</script>

</body>
</html>