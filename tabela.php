<?php

include "db.php";

$selectProdutos = "SELECT * FROM produtos";
$queryProdutos = $connection->query($selectProdutos);

function exibirProdutos(){
    global $queryProdutos;
    if ($queryProdutos->num_rows > 0){
        echo "
            <table>
            <tr>
            <th>Nome</th>
            <th>Quantidade</th>
            <th>Valor por unidade (R$)</th>
            <th>Imagem</th>
            </tr>
            ";
        while($row = $queryProdutos->fetch_assoc()){
            echo "<tr>";
            
            // Formulário para cada produto
            echo "<form action='update.php' method='POST' enctype='multipart/form-data'>";
            
            echo "<td>" . "<input type='text' class='nome_{$row['id']}' name='nome' value='{$row['nome']}'>" . "</td>";
            echo "<td>" . "<input type='number' class='quantidade_{$row['id']}' name='quantidade' value='{$row['quantidade']}'>" . "</td>";
            echo "<td>" . "<input type='number' class='valor_{$row['id']}' name='valor' value='{$row['valor']}'>" . "</td>";
            
            // Exibe a imagem atual
            echo "<td>";
            if (!empty($row['img'])) {
                echo "<label for='img_upload_{$row['id']}'><img src='{$row['img']}' width='100' height='100' alt='Imagem do produto' style='cursor: pointer;'></label>";
                echo "<input type='file' id='img_upload_{$row['id']}' class='img_{$row['id']}' name='img' accept='image/png, image/jpeg' style='display: none;'>";
            } else {
                echo "<input type='file' class='img_{$row['id']}' name='img' accept='image/png, image/jpeg'>";
            }
            echo "</td>";
            
            // Campos hidden para passar o ID do produto
            echo "<input type='hidden' name='id' value='{$row['id']}'>";

            // Botões de ação (Salvar e Apagar)
            echo "<td><input type='submit' name='atualizar' value='Salvar alterações'></td>";
            echo "<td><input type='submit' name='apagar' value='Apagar'></td>";
            
            echo "</form>";
            echo "</tr>";
        }
        echo "</table>";
    } else{
        echo "<p>Sem produtos cadastrados</p>";
    }
}

$connection->close();
?>
