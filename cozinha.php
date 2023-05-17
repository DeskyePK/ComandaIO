<?php
require_once ("BackEnd/cozinharecive.php");
if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 1) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/stylecozinha.css" media="screen" />  
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Gestao Cozinha</title>
</head>
<body>
</body>
<script>
    
    function concluirPedido(idPedido) {
  $.ajax({
    url: "BackEnd/atualizar_pedido.php",
    method: "POST",
    data: { id_pedido: idPedido },
    success: function(response) {
      alert("Pedido concluído com sucesso!");
      
      $('#pedido_' + idPedido).closest('tr').remove();
    },
    error: function() {
      alert("Erro ao concluir o pedido.");
    }
  });
}
</script>
</html>