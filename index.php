<?php
$nome = "";
$email = "";
$telefone = "";
$mensagem = "";
$tipoMensagem = "";

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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema Web II - Cadastro de Usuário</title>
  <link rel="stylesheet" href="style.css">
</head>
    
<body>
  <div class="container">
    <h1>Cadastro de Usuário</h1>
    <p>Preencha os dados abaixo.</p>

    <form method="POST" action="">
      <label for="nome">Nome:</label><br>
      <input type="text" id="nome" name="nome" required value="<?php echo htmlspecialchars($nome); ?>">

      <label for="email">E-mail:</label><br>
      <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($email); ?>">

      <label for="telefone">Telefone:</label><br>
      <input type="text" id="telefone" name="telefone" required value="<?php echo htmlspecialchars($telefone); ?>">

      <button type="submit">Cadastrar</button>
    </form>

    <?php if ($mensagem !== ""): ?>
      <div class="mensagem <?php echo $tipoMensagem; ?>">
        <?php echo htmlspecialchars($mensagem); ?>
      </div>
    <?php endif; ?>

    <h2 style="margin-top: 35px;">Usuários cadastrados</h2>

    <?php if ($resultLista && pg_num_rows($resultLista) > 0): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($usuario = pg_fetch_assoc($resultLista)): ?>
            <tr>
              <td><?php echo htmlspecialchars($usuario["id"]); ?></td>
              <td><?php echo htmlspecialchars($usuario["nome"]); ?></td>
              <td><?php echo htmlspecialchars($usuario["email"]); ?></td>
              <td><?php echo htmlspecialchars($usuario["telefone"]); ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="sem-registros">Nenhum usuário cadastrado.</p>
    <?php endif; ?>
  </div>
</body>
</html>

