<?php
$servername = "comandaio.crqtiiw27p2g.us-east-1.rds.amazonaws.com";
$username = "deskye";
$password = "Senha123!";
$dbname = "comandaio";

// Cria a conexão
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else{
}

?>
