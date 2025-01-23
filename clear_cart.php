<?php
include "db.php";
session_start();
    $pessoa_id = $_SESSION['dbid'];

    // Exclui todos os itens do carrinho para o usuário logado
    $queryDeleteAll = $connection->prepare("DELETE FROM carrinho WHERE pessoa_id = ?");
    $queryDeleteAll->bind_param("i", $pessoa_id);
    $queryDeleteAll->execute();

    // Após a operação, redireciona para a página do carrinho
    header("Location: cart.php");
    exit();
?>
