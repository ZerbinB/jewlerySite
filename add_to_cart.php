<?php

session_start();
include "db.php";  // Conectar ao banco de dados


// Verifica se os dados do produto foram passados corretamente
if (isset($_POST['produto_id'], $_POST['quantidade']) && is_numeric($_POST['produto_id']) && is_numeric($_POST['quantidade'])) {
    $produto_id = $_POST['produto_id'];  // ID do produto
    $quantidade = $_POST['quantidade'];  // Quantidade do produto
    $pessoa_id = $_SESSION['dbid'];  // ID do usuário logado

    // Verifica se o produto já está no carrinho do usuário
    $query = $connection->prepare("SELECT id FROM carrinho WHERE pessoa_id = ? AND produto_id = ?");
    $query->bind_param("ii", $pessoa_id, $produto_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // O produto já está no carrinho, atualiza a quantidade
        $queryUpdate = $connection->prepare("UPDATE carrinho SET quantidade = quantidade + ? WHERE pessoa_id = ? AND produto_id = ?");
        $queryUpdate->bind_param("iii", $quantidade, $pessoa_id, $produto_id);
        if ($queryUpdate->execute()) {
            // Atualização bem-sucedida
            header("Location: in_site.php");
            exit();
        } else {
            echo "Erro ao atualizar a quantidade no carrinho.";
        }
    } else {
        // Adiciona novo produto ao carrinho
        $queryInsert = $connection->prepare("INSERT INTO carrinho (pessoa_id, produto_id, quantidade) VALUES (?, ?, ?)");
        $queryInsert->bind_param("iii", $pessoa_id, $produto_id, $quantidade);
        if ($queryInsert->execute()) {
            // Produto adicionado com sucesso
            header("Location: in_site.php");
            exit();
        } else {
            echo "Erro ao adicionar produto ao carrinho.";
        }
    }
} else {
    echo "Dados inválidos.";
}
?>
