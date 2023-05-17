<?php
session_start();
require_once("conexao.php");

if(isset($_POST['Usuario']) && isset($_POST['Senha'])){
    //declara as variaveis
    $Usuario = $_POST['Usuario']; 
    $Senha = $_POST['Senha'];


    $query = "SELECT * FROM Usuarios WHERE BINARY Usuario = '$Usuario' AND BINARY Senha = '$Senha'";
    $get = $conn->query($query);
    $num = mysqli_num_rows($get);


    if($num == 1){
        while($percorrer = mysqli_fetch_array($get)){
            $id_u = $percorrer['id_u'];
            $Nivel = $percorrer['Nivel'];
            $_SESSION['Usuario'] = $_POST['Usuario'];
            $_SESSION['Nivel'] = $Nivel;
            $_SESSION['id_u'] = $id_u;

            if($Nivel == 1){
                header("Location: ../cozinha.php");
            }elseif($Nivel == 2){
                header("Location: ../cardapio.php");
            }elseif($Nivel == 3){
                header("Location: ../GestorDirect.php");
            }else{
                $_SESSION['erro_login'] = true;
                header("Location: ../index.php");
            }
         }
    }else{
        $_SESSION['erro_login'] = true;
        header("Location: ../index.php");
    }
}
?>