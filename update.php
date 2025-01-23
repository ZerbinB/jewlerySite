<?php
include "db.php";

// Atualiza o produto
if (isset($_POST['atualizar'])) {
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $quantidade = $_POST['quantidade'];
    $valor = $_POST['valor'];
    $img = ""; // imagem será atualizada, mas se não houver nova imagem, a original será mantida

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK) {
        $uploadFileDir = 'uploads/';
        $fileName = basename($_FILES["img"]["name"]);
        $filePath = $uploadFileDir . uniqid() . '_' . $fileName;
        if (move_uploaded_file($_FILES["img"]["tmp_name"], $filePath)) {
            $img = $filePath;
        } else {
            echo "Erro ao mover o arquivo para o diretório de upload.";
            exit;
        }
    } else {
        // Se não houver imagem, mantém a imagem anterior no banco de dados
        $selectQuery = "SELECT img FROM produtos WHERE id=?";
        $stmt = $connection->prepare($selectQuery);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($img);
        $stmt->fetch();
        $stmt->close();
    }

    // Atualiza os dados no banco de dados
    $updateQuery = "UPDATE produtos SET nome=?, quantidade=?, valor=?, img=? WHERE id=?";
    $stmt = $connection->prepare($updateQuery);
    $stmt->bind_param("sidsi", $nome, $quantidade, $valor, $img, $id);

    if ($stmt->execute()) {
        echo "Produto atualizado com sucesso!";
        header('Location: index.php'); // Redireciona de volta para a lista de produtos
    } else {
        echo "Erro ao atualizar o produto.";
    }
    $stmt->close();
}

// Apaga o produto
if (isset($_POST['apagar'])) {
    $id = $_POST['id'];

    // Deleta o produto
    $deleteQuery = "DELETE FROM produtos WHERE id=?";
    $stmt = $connection->prepare($deleteQuery);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Produto apagado com sucesso!";
        header('Location: index.php'); // Redireciona de volta para a lista de produtos
    } else {
        echo "Erro ao apagar o produto.";
    }
    $stmt->close();
}

$connection->close();
?>
