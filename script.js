function enviarDados() {
    var nome = document.getElementById("nome").value;
    var telefone = document.getElementById("telefone").value;
    var email = document.getElementById("email").value;
 
    if (nome === "" || telefone === "" || email === "") {
        alert("Preencha todos os campos!");
        return;
    }

    if (!email.includes("@")){
    alert("Você precisa colocar um endereço de e-mail valido!")
        return;
    }

    document.getElementById("mensagem").innerHTML = "Dados recebidos com sucesso!";
 
    document.getElementById("resultado").innerHTML =
        "<p><strong>Nome:</strong> " + nome + "</p>" +
        "<p><strong>Telefone:</strong> " + telefone + "</p>" +
        "<p><strong>E-mail:</strong> " + email + "</p>";
 
    document.getElementById("nome").value = "";
    document.getElementById("telefone").value = "";
    document.getElementById("email").value = "";
}
