<?php
session_start();
include "db.php";

// Adicionar as informações do produto no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["senha"])) {
        // Captura os dados do formulário
        $nome = $_POST["nome"];
        $email = $_POST["email"];
        $senha = $_POST["senha"];

        $selectPessoas = "SELECT * FROM pessoas WHERE email = ?";
        $stmt = $connection->prepare($selectPessoas);
        $stmt->bind_param("s", $email);  // Parâmetro base
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>
            alert('Você já possui cadastro!\\nSendo redirecionado à página de Login.');
            window.location.href='sign_in.php';
            </script>";
            $stmt->close();  // Fechar o stmt antes de sair do script
            exit();  // Interrompe o restante da execução após o alerta
        } else {
            // Antes de armazenar no banco de dados, esconde a senha
            $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

            // Inserir os dados no banco
            $insertDados = "INSERT INTO pessoas (nome, email, senha) VALUES (?, ?, ?)";
            $stmt = $connection->prepare($insertDados);
            $stmt->bind_param("sss", $nome, $email, $senhaHash);

            if ($stmt->execute()) {
                $last_id = $connection->insert_id; // Captura o ID do último registro
                $_SESSION['dbid'] = $last_id; // Armazena na sessão
                $_SESSION['dbnome'] = $nome;
                $_SESSION['dbemail'] = $email;
                $_SESSION['dbadmin'] = 0;
                echo "<script>
                alert('{$last_id}. {$_SESSION['dbid']}');
                window.location.href='in_site.php';
                </script>";
                exit();
            } else {
                echo "Erro ao cadastrar: " . $stmt->error;
            }
        }

        $stmt->close();  // Fechar o stmt após a execução
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

$connection->close();  // Fechar a conexão com o banco de dados
?>
