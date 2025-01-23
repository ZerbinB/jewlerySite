<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Cadastre-se</title>
</head>
<body>
<form onsubmit="return isValid()" action="pessoas.php" method="POST" enctype="multipart/form-data">
  <div class="form">
    <h1>Cadastre-se</h1>
    
    <label for="nome">Nome Completo</label>
    <input type="text" id="nome" name="nome" required/>

    <label for="email">Email</label>
    <input type="text" name="email" required>

    <label for="senha">Senha</label>
    <br>
    <input type="password" id="senha" name="senha" oninput="checksenhaMatch()" required>
    <br>
    <label for="senha-rpt">Repita a Senha</label>
    <br>
    <input type="password" id="senha-rpt" name="senha-rpt" oninput="checksenhaMatch()" required>
    <br>
    <span id="message"></span>
    <br>

    <label for="terms">Eu li e concordo com os <a href="#">termos de uso</a>.</label>
    <input type="checkbox" name="terms" required="required">

    <div class="end">
      <input type="submit" class="signupbtn" value="Concluir">
    </div>
  </div>
</form>


<script>
  // Pega os dados das senhas e se as senhas não forem iguais, exibe mensagem de erro
function checksenhaMatch() {
    var senha = document.getElementById("senha").value;
    var senhaRpt = document.getElementById("senha-rpt").value;
    var message = document.getElementById("message");

    
    if (senha !== senhaRpt) {
        message.textContent = "As senhas não coincidem.";
        message.style.color = "red";
        return false
    } else {
        message.textContent = "As senhas coincidem.";
        message.style.color = "green";
    }
}

function isValid(){
  if (checksenhaMatch() == false){
    alert("Senhas não coincidem.")
    return false;
  }
  return true;

}
</script>

</body>
</html>