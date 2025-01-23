<?php
session_start();
include "db.php";
include "logins.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["senha"])) {
        
        $email = $_SESSION["dbemail"];
        $senha = $_POST["senha"];
        $selectPessoas = "SELECT * FROM pessoas WHERE email = ?";
        $stmt = $connection->prepare($selectPessoas);
        $stmt->bind_param("s", $email);  // Parâmetro base
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($dbid, $dbnome, $dbemail, $dbsenha, $dbadmin);
            $stmt->fetch();

            if (password_verify($senha, $dbsenha)){
                $_SESSION['dbid'] = $dbid;
                $_SESSION['dbnome'] = $dbnome;
                $_SESSION['dbadmin'] = $dbadmin;
                $_SESSION['dbemail'] = $dbemail;

                header('Location: end_clear.php');
                exit();
            }
            else{
                echo "<script>
                alert('Senha incorreta.');
                window.location.href='cart.php';
                </script>";
                exit();
            }
        }

    }

}
$connection->close();
?>