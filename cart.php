<?php
include "db.php";
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="cart.css" rel="stylesheet" type="text/css" />
    <title>Carrinho</title>
</head>
<body>

    <header>
        <h1>Seu carrinho</h1>
    </header>
    <div id='test'>
            <?php
                if (isset($_SESSION['dbid'])) {
                    $pessoa_id = $_SESSION['dbid'];
                    
                    // Consulta os itens no carrinho incluindo o id do produto
                    $queryCarrinho = $connection->prepare("SELECT c.id AS carrinho_id, c.quantidade, p.id AS produto_id, p.nome, p.valor, p.img FROM carrinho c JOIN produtos p ON c.produto_id = p.id WHERE c.pessoa_id = ?");
                    $queryCarrinho->bind_param("i", $pessoa_id);
                    $queryCarrinho->execute();
                    $resultCarrinho = $queryCarrinho->get_result();

                    $queryEstoque = $connection->prepare("SELECT quantidade FROM produtos WHERE id = ?");
                    $queryEstoque->bind_param("i", $produto_id);
                    $queryEstoque->execute();
                    $resultEstoque = $queryEstoque->get_result();
                    $estoque = $resultEstoque->fetch_assoc();

                    if ($resultCarrinho->num_rows > 0) {
                        $total = 0;
                        echo "<div id='a'>";
                        while ($item = $resultCarrinho->fetch_assoc()) {
                            $subtotal = $item['quantidade'] * $item['valor'];
                            $total += $subtotal;

                            // Verificar o estoque do produto atual
                            $queryEstoque = $connection->prepare("SELECT quantidade FROM produtos WHERE id = ?");
                            $queryEstoque->bind_param("i", $item['produto_id']);
                            $queryEstoque->execute();
                            $resultEstoque = $queryEstoque->get_result();
                            $estoque = $resultEstoque->fetch_assoc();

                            // Garantir que o estoque foi encontrado, caso contrário, define 0
                            $estoqueQuantidade = $estoque ? $estoque['quantidade'] : 0;
    
                            // Agora usando o produto_id corretamente

                            echo "<form action='alter_cart.php' method='POST' id='cart_box'>";
                            echo "<img src='" . htmlspecialchars($item['img']) . "' alt='" . htmlspecialchars($item['nome']) . "' class='product_image'>";
                            echo "<div>";
                            echo "<p>" . htmlspecialchars($item['nome']) . "</p>";
                            echo "<p>Preço: R$" . number_format($item['valor'], 2) . "</p>";
                            echo "<p>Subtotal: R$" . number_format($subtotal, 2) . "</p>";
                            echo "</div>";
                            echo "<input type='hidden' name='produto_id' value='" . htmlspecialchars($item['produto_id']) . "'>";
                            echo "<div>";
                            echo "<input type='number' name='quantidade' value='" . htmlspecialchars($item['quantidade']) . "' min='0' max='" . htmlspecialchars($estoque['quantidade']) . "'>";
                            echo "<input type='submit' value='Alterar Quantidade'>";
                            echo "</div>";
                            echo "</form>";
                        }                      
                        echo "<form action='clear_cart.php' method='POST'>";
                        echo    "<input type='submit' value='Apagar Carrinho'>";
                        echo "</form>";
                        echo "</div>";
                        echo "<form action='cart_finish.php' method='POST' id='finish'>";
                        echo "<h3>Confirme seus dados</h3>
                             <p> Nome completo: " . htmlspecialchars($_SESSION['dbnome']) . "</p>
                             <p> E-mail: " . htmlspecialchars($_SESSION['dbemail']) . "</p>";
                        echo "<p>Retirada e pagamento possíveis apenas na loja física.</p>";
                        echo "<p style='margin-bottom:0px'>Método de pagamento</p>
                                <input list='methods' name='methods' id='method' onclick='this.value=\"\" ' required>
                                    <datalist id='methods'>
                                    <option value='Dinheiro Físico'>
                                    <option value='Pix'>
                                    <option value='Débito'>
                                    <option value='Crédito'>
                                    </datalist>";
                        echo "<input type='password' id='senha' name='senha' required placeholder='Insira sua senha'>";
                        echo "<p>Total: R$" . number_format($total, 2) . "</p>";
                        echo '<input type="submit" value="Finalizar compra">';
                        echo "</form>";
                    } else {
                        echo "<p style='font-size:100%; margin-top:30px'>Seu carrinho está vazio.</p>";
                        echo "<a id='button' href='in_site.php'>Continuar comprando</a>";
                        
                        echo "<a href='in_site.php'><img src='banner.png' alt='banner da loja' style='width:70rem; margin-top:80px; max-width:1000px'></a>";
                    }
                    
                } else {
                    echo "<p>Por favor, faça login para ver o carrinho.</p>";
                }
            ?>
    </div>
    <script>
    </script>
</body>
</html>
