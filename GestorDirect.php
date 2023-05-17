<?php
require_once ("BackEnd/login.php");

if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 3) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="stylesheet" type="text/css" href="Style/stylegestor.css" media="screen" />
    <title>Painel de Gerenciamento</title>
</head>
<body>
<a href="Index.php" id="btnVoltar"><img src="Icons/back.png" alt="Voltar"></a>
    <div Class="GestorBox">
   
    <h1>Painel de Gerenciamento</h1>
    
    <p>Selecione a opção de gerenciamento desejada:</p>
    <button type="button" onclick="window.location.href='GestaoDeDados.php'">Gestão de Usuários</button>
    <button type="button" onclick="window.location.href='GestaoDePratos.php'">Gestão de Pratos</button>
    <button type="button" onclick="window.location.href='GestaoCupom.php'">Gestão de Cupons</button>


</div>
</body>
</html>