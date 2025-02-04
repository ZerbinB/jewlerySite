# jewlerySite
Website for a ficticious jewlery store, including it's own visual design, item stock, sales system and client registration. This project was made using HTML, CSS, JavaScript, PHP and MySql. All code was written within VSCode.

# Requirements
- XAMPP to access MySql;
- A databank named 'cadastroprodutos' and three tables within it named 'produtos', 'pessoas' and 'carrinho';
- 'carrinho' must be a joint table from 'pessoas' and 'produtos' via Foreign Keys;

# Create all tables with:
CREATE TABLE produtos (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    quantidade INT NOT NULL,
    valor DECIMAL(10,2) NOT NULL
)

CREATE TABLE cadastroprodutos.pessoas
