<?php
require_once 'conexao.php';

$usuarioId = $_SESSION['id_u'];
$sql = "SELECT pedidos.id_p, pratos.Nome, pedidos.quantidade, pedidos.status
        FROM pedidos
        JOIN pratos ON pratos.id = pedidos.produto_id
        WHERE pedidos.usuario_id = $usuarioId AND pedidos.status = 'pendente'
        ORDER BY pedidos.id_p ASC";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
  while ($row = $resultado->fetch_assoc()) {
    if ($row['status'] == 'concluido') {
      $id_pedido = $row['id_p'];
      $status_atualizado = true;
      $sql = "UPDATE pedidos SET status = 'atualizado' WHERE id_p = $id_pedido";
      $conn->query($sql);
      echo json_encode(array('status_atualizado' => $status_atualizado, 'id_pedido' => $id_pedido));
      exit();
    }
  }
}

echo json_encode(array('status_atualizado' => false));
?>