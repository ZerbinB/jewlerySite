<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css" />
    <title>Entre</title>
</head>
<body>
<form action="validate.php" method="POST" enctype="multipart/form-data">
  <div class="form">
    <h1>Entre</h1>

    <label for="email">Email</label>
    <input type="text" name="email" required>

    <label for="senha">Senha</label>
    <br>
    <input type="password" id="senha" name="senha" required>
    <br>

    <span>Não possui cadastro?<a href="sign_up.php">Cadastre-se.</a></span>
    <br>


    <div class="end">
      <input type="submit" class="signupbtn" value="Concluir">
    </div>
  </div>
</form>



<script>
</script>

</body>
</html>