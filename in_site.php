<?php
session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Prata Serena</title>
  <link href="prata.css" rel="stylesheet" type="text/css" />
</head>

<body>
  <header>

    <input id="search" type="text" placeholder="Buscar" oninput="searchBar()">
    <img id="logo" src="Logo2.png" alt="Logo Prata Serena">
    <div id="info">
      <?php
      if (isset($_SESSION['dbid'])) {
        echo "<div id='cart_box'>";
        echo "<a href='cart.php' id='cart'>Carrinho</a>";
        echo "</div>";
        echo "<div id='sign_box'>";
        echo "<a href='logout.php'>Encerrar sessão</a>";
        if ($_SESSION['dbadmin'] == 1) {
          echo "<a href='index.php'>Estoque</a>";
          
        }
        echo "</div>";
      } else {
        echo "<div id='sign_box'>";
        echo "<a href='sign_up.php' target='blank'>Cadastre-se</a>";
        echo "<a href='sign_in.php' target='blank'>Entrar</a>";
        echo "</div>";
      }
      ?>
    </div>
  </header>

  <main>
    <div id="products_container">
      <?php
      include "db.php";

      $selectProdutos = "SELECT * FROM produtos";
      $queryProdutos = $connection->query($selectProdutos);

      if ($queryProdutos->num_rows > 0) {
          while ($row = $queryProdutos->fetch_assoc()) {
              echo "<div class='product' data-name='" . htmlspecialchars($row['nome']) . "'>";
              echo "<h2>" . htmlspecialchars($row['nome']) . "</h2>";
              echo "<img src='" . htmlspecialchars($row['img']) . "' alt='" . htmlspecialchars($row['nome']) . "'/>";
              echo "<p>Em estoque: " . htmlspecialchars($row['quantidade']) . '<br>' . "Preço: R$" . htmlspecialchars(number_format($row['valor'], 2)) . "</p>";

              if (!isset($_SESSION['dbid'])) {
                echo "<a id='sign' href='sign_in.php?id=" . htmlspecialchars($row['id']) . "'>Entre para comprar</a>";
              } else {
                echo "<form action='add_to_cart.php' method='POST'>";
                echo "<input type='hidden' name='produto_id' value='" . htmlspecialchars($row['id']) . "'>";
                echo "<input type='number' name='quantidade' value='1' min='1' max='" . htmlspecialchars($row['quantidade']) . "'>";
                echo "<input type='submit' value='Adicionar ao carrinho'>";
                echo "</form>";
              }
              echo "</div>";
          }
      } else {
          echo "Nenhum produto encontrado.";
      }
      ?>
    </div>
  </main>
  <div id='banner'>
    <img src="banner.png" alt="banner da loja" style="width:100%">
  </div>
  <script>
    function searchBar() {

      const searchValue = document.getElementById("search").value.toLowerCase();


      const products = document.querySelectorAll(".product");


      products.forEach(product => {
        const productName = product.getAttribute("data-name").toLowerCase();
        if (productName.includes(searchValue)) {
          product.style.display = "block";
        } else {
          product.style.display = "none";
        }
      });
    }
  </script>
</body>

</html>
