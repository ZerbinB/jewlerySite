<?php
include "db.php";
session_start();
    $pessoa_id = $_SESSION['dbid'];

    // Exclui todos os itens do carrinho para o usuário logado
    $queryDeleteAll = $connection->prepare("DELETE FROM carrinho WHERE pessoa_id = ?");
    $queryDeleteAll->bind_param("i", $pessoa_id);
    $queryDeleteAll->execute();

    header("Location: cart_success.php");
    exit();
?>
