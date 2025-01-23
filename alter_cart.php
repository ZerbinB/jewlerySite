<?php
include "db.php";
session_start();

// Verifica se os dados do produto foram passados corretamente
if (isset($_POST['produto_id'], $_POST['quantidade']) && is_numeric($_POST['produto_id']) && is_numeric($_POST['quantidade'])) {
    $produto_id = $_POST['produto_id'];  // ID do produto
    $quantidade = $_POST['quantidade'];  // Quantidade a ser atualizada
    $pessoa_id = $_SESSION['dbid'];  // ID do usuário logado

    if ($quantidade <= 0) {
        // Se a quantidade for 0 ou menor, remove o produto do carrinho
        $queryDelete = $connection->prepare("DELETE FROM carrinho WHERE pessoa_id = ? AND produto_id = ?");
        $queryDelete->bind_param("ii", $pessoa_id, $produto_id);
        $queryDelete->execute();
    } else {
        // Caso contrário, atualiza a quantidade
        // Verifica se a quantidade não é maior que o estoque disponível
        $queryEstoque = $connection->prepare("SELECT quantidade FROM produtos WHERE id = ?");
        $queryEstoque->bind_param("i", $produto_id);
        $queryEstoque->execute();
        $resultEstoque = $queryEstoque->get_result();
        $estoque = $resultEstoque->fetch_assoc();

        if ($quantidade <= $estoque['quantidade']) {
            // Se a quantidade solicitada for menor ou igual ao estoque, atualiza
            $queryUpdate = $connection->prepare("UPDATE carrinho SET quantidade = ? WHERE pessoa_id = ? AND produto_id = ?");
            $queryUpdate->bind_param("iii", $quantidade, $pessoa_id, $produto_id);
            $queryUpdate->execute();
        } else {
            // Caso a quantidade solicitada seja maior que o estoque, retorna um erro
            echo "<script>
            alert('Quantidade excede o estoque.');
            </script>";
            exit();
        }
    }

    // Após a operação, redireciona para o carrinho
    header("Location: cart.php");
    exit();
} else {
    echo "Dados inválidos!";
}
?>

