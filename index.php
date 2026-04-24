<?php
$nome = "";
$email = "";
$telefone = "";

$db_url = getenv("DATABASE_URL");

if (!$db_url) {
    die("Erro: variável DATABASE_URL não encontrada.");
}

$conn = pg_connect($db_url);

if (!$conn) {
    die("Erro ao conectar no banco de dados.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $telefone = trim($_POST["telefone"] ?? "");

    if ($nome === "" || $email === "" || $telefone === "") {
        $mensagem = "Preencha todos os campos.";
        $tipoMensagem = "erro";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = "Digite um e-mail válido.";
        $tipoMensagem = "erro";
    } else {
        $query = "INSERT INTO usuarios (nome, email, telefone) VALUES ($1, $2, $3)";
        $result = pg_query_params($conn, $query, [$nome, $email, $telefone]);

        if ($result) {
            $mensagem = "Usuário cadastrado com sucesso no banco de dados.";
            $tipoMensagem = "sucesso";

            $nome = "";
            $email = "";
            $telefone = "";
        } else {
            $mensagem = "Erro ao salvar no banco de dados.";
            $tipoMensagem = "erro";
        }
    }
}

$queryLista = "SELECT id, nome, email, telefone FROM usuarios ORDER BY id DESC";
$resultLista = pg_query($conn, $queryLista);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Atividade</title>

    <link rel="stylesheet" href="style.css">
    
</head>
<body>

    <div class="container">
    <h2>Cadastro de Usuário</h2>
 
    <input type="text" id="nome" placeholder="Digite seu nome"><br><br>
    <input type="text" id="telefone" placeholder="Digite seu telefone"><br><br>
    <input type="email" id="email" placeholder="Digite seu e-mail"><br><br>
    <button onclick="enviarDados()">Enviar</button>
    </div>
 
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
