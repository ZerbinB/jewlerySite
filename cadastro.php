<?php


include "db.php"; // Conexão com o banco de dados
 
// Adicionar as informações do produto no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = $_POST["nome"];
    $quantidade = $_POST["quantidade"];
    $valor = $_POST["valor"];

    // Verifica se um arquivo foi enviado
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
        // Define o diretório onde a imagem será armazenada
        $uploadFileDir = 'uploads/';
        
        // Gera um nome único para a imagem
        $fileName = basename($_FILES["img"]["name"]);
        $filePath = $uploadFileDir . uniqid() . '_' . $fileName;

        // Move o arquivo enviado para o diretório especificado
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)) {
            //insere os dados no banco de dados
            $insertDados = "INSERT INTO produtos (nome, quantidade, valor, img) VALUES (?, ?, ?, ?)";
            $stmt = $connection->prepare($insertDados);
            $stmt->bind_param("siis", $nome, $quantidade, $valor, $filePath);
            $stmt->execute();
            $stmt->close();

            // redireciona
            header('Location: index.php');
            exit();
        } else {
            echo "Erro ao mover o arquivo para o diretório de upload.";
        }
    } else {
        echo "Nenhuma imagem foi enviada ou ocorreu um erro.";
    }
}

$connection->close();
?>


