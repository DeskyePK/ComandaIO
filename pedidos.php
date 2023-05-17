<?php
require_once 'BackEnd/login.php';
require_once 'BackEnd/conexao.php';

if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 2) {
  header("Location: index.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="Style/styleuserped.css" media="screen" />
 
  <title>Pedidos</title>
</head>
<body>
<audio id="audioPedidoConcluido" src="Audio/concluido.mp3"></audio>
  <?php
  $usuarioId = $_SESSION['id_u'];

  // Consulta para buscar pedidos pendentes
  $sqlPendentes = "SELECT pedidos.id_p, pratos.Nome, pedidos.quantidade, pedidos.status
          FROM pedidos
          JOIN pratos ON pratos.id = pedidos.produto_id
          WHERE pedidos.usuario_id = $usuarioId AND pedidos.status = 'pendente'
          ORDER BY pedidos.id_p ASC";
  $resultadoPendentes = $conn->query($sqlPendentes);

  if ($resultadoPendentes->num_rows > 0) {
    echo '<ul>';
    echo '<li><a href="./cardapio.php">Inicio</a></li>';
    echo '</ul>';

    echo "<div class='container'>";
    echo "<h1>Meus Pedidos Pendentes</h1>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr><th>Produto</th><th>Quantidade</th><th>Status</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = $resultadoPendentes->fetch_assoc()) {
      echo "<tr>";
      echo "<td class='format'>" . $row["Nome"] . "</td>";
      echo "<td class='format'>" . $row["quantidade"] . "</td>";
      echo "<td class='format'>" . $row["status"] . "</td>";
      echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  }

  // Consulta para buscar pedidos concluídos
  $sqlConcluidos = "SELECT pedidos.id_p, pratos.Nome, pedidos.quantidade, pedidos.status, pedidos.hora_conclusao
          FROM pedidos
          JOIN pratos ON pratos.id = pedidos.produto_id
          WHERE pedidos.usuario_id = $usuarioId AND pedidos.status = 'concluido' AND pedidos.hora_conclusao >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)
          ORDER BY pedidos.id_p ASC";
  $resultadoConcluidos = $conn->query($sqlConcluidos);

  if ($resultadoConcluidos->num_rows > 0) {
    echo "<div class='container'>";
    echo "<h1>Meus Pedidos Concluídos</h1>";
    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr><th>Produto</th><th>Quantidade</th><th>Status</th><th>Hora da Conclusão</th></tr>";
    echo "</thead>";
    echo "<tbody>";
    while($row = $resultadoConcluidos->fetch_assoc()) {

      
      echo "<tr>";
      echo "<td class='format'>" . $row["Nome"] . "</td>";
      echo "<td class='format'>" . $row["quantidade"] . "</td>";
      echo "<td class='format'>" . $row["status"] . "</td>";
      echo "<td class='format'>" . $row["hora_conclusao"] . "</td>";
      echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
  
    // reproduzir o áudio de novo pedido concluído
    echo "<script>document.getElementById('audioPedidoConcluido').play();</script>";
  }
      
     
      if ($resultadoPendentes->num_rows == 0 && $resultadoConcluidos->num_rows == 0) {
        $_SESSION['mensagem'] = "Você ainda não realizou nenhum pedido";
        header("Location: cardapio.php");
        exit();
      }   
      
      $conn->close();
      ?>
      </body>
      <script>
      setTimeout(function(){
        location.reload();
      }, 60000);

    </script>
      </html>