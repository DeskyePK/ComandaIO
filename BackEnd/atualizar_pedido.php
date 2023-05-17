<?php
require_once 'login.php';
require_once 'conexao.php';

// Verifica se o ID do pedido foi enviado na solicitação
if (isset($_POST['id_pedido'])) {
  $idPedido = $_POST['id_pedido'];

  // Atualiza o status do pedido para "concluído"
  $sql = "UPDATE pedidos SET status = 'concluido', hora_conclusao = NOW() WHERE id_p = $idPedido";

  $resultado = $conn->query($sql);

  if ($resultado) {
    echo "Pedido atualizado com sucesso.";
  } else {
    echo "Erro ao atualizar o pedido.";
  }
} else {
  echo "ID do pedido não enviado.";
}
?>