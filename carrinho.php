<?php

require_once ("BackEnd/carrinho.php");
if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 2) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt_BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/stylecarrinho.css" media="screen" />
    <title>Cardapio.IO</title>
</head>
<body>
    
</body>
</html>