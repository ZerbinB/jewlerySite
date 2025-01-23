<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Sistema de cadastro de produtos</title>
</head>
<body>
    <h1>Sistema de cadastro de produtos</h1>
    <form action="cadastro.php" method="POST" enctype="multipart/form-data">
        <label>Nome do produto:</label>
        <input type="text" name="nome">
        <br>
        <label>Quantidade:</label>
        <input type="number" min="0" name="quantidade">
        <br>
        <label>Valor por unidade:</label>
        <input type="number" min="0" name="valor">
        <br>
        <label>Imagem</label>
        <br>
        <input type="file" name="img"  class="$row[id]" value="$row[img]" accept="image/png, image/jpeg" required>

        <input type="submit" value="Cadastrar produto">
    </form>
    <p>Produtos cadastrados:</p>
    <?php
    include "tabela.php";
    exibirProdutos();
    ?>

    <script>
// Função para atualizar os dados de um produto

function atualizarDados(id) {
    const nome = document.getElementById(`nome_${id}`).value;
    const quantidade = document.getElementById(`quantidade_${id}`).value;
    const valor = document.getElementById(`valor_${id}`).value.replace(',', '.');
    const imgInput = document.getElementById(`img_upload_${id}`);
    let formData = new FormData();

    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("quantidade", quantidade);
    formData.append("valor", valor);

    // Verifica se uma nova imagem foi selecionada
    if (imgInput.files.length > 0) {
        formData.append("img", imgInput.files[0]);
    }

    console.log("Dados enviados:", {
    id,
    nome,
    quantidade,
    valor,
    img: imgInput.files.length > 0 ? imgInput.files[0].name : "Sem nova imagem",
});


    fetch("update.php", {
        method: "POST",
        body: formData,
    })
        .then((response) => response.text())
        .then((data) => {
            alert(data); // Exibe a mensagem de sucesso ou erro do PHP
            location.reload(); // Recarrega a página para refletir as alterações
        })
        .catch((error) => console.error("Erro ao atualizar o produto:", error));
}


// Função para apagar um produto
function apagarDados(id) {
    if (confirm("Tem certeza que deseja apagar este produto?")) {
        fetch("delete.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${id}`,
        })
            .then((response) => response.text())
            .then((data) => {
                alert(data); // Exibe a mensagem de sucesso ou erro
                location.reload(); // Recarrega a página para refletir as alterações
            })
            .catch((error) => console.error("Erro ao apagar o produto:", error));
    }
}

    </script>
</body>
</html>