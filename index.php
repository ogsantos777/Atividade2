<?php
$nome = "";
$email = "";
$telefone = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"] ?? "";
    $email = $_POST["email"] ?? "";
    $telefone = $_POST["telefone"] ?? "";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade</title>
</head>
<body>
 
    <h2>Cadastro de Usuário</h2>
 
    <input type="text" id="nome" placeholder="Digite seu nome"><br><br>
    <input type="text" id="telefone" placeholder="Digite seu telefone"><br><br>
    <input type="email" id="email" placeholder="Digite seu e-mail"><br><br>
    <button onclick="enviarDados()">Enviar</button>
 
    <h3 id="mensagem"></h3>
    <div id="resultado"></div>
    <script src="script.js"></script>
 
</body>
</html>

  <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <h2>Dados recebidos pelo servidor</h2>
    <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
    <p><strong>E-mail:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Telefone:</strong> <?php echo htmlspecialchars($telefone); ?></p>
  <?php endif; ?>

</body>
</html>
