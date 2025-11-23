<?php
session_start();

$senhaCorreta = "12345"; // TROQUE AQUI

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $senha = $_POST['senha'];

    if ($senha === $senhaCorreta) {
        $_SESSION['adm'] = true;
        header("Location: index.php");
        exit();
    } else {
        $erro = "Senha incorreta!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADM NichoStudios</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body class="login">

<form method="POST" class="login">
    <h2>NICHO STUDIOS</h2>
    <input type="password" name="senha" placeholder="Senha">
    <button type="submit">Entrar</button>
    <p class="Perro"><?php echo $erro ?? ""; ?></p>
</form>
<script>
    setTimeout(() => {
        const erro = document.querySelector('.Perro');
        if (erro) {
            erro.style.display = 'none';
        }
    }, 3000); 
</script>
</body>
</html>
