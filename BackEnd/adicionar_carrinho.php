<?php
session_start();
require_once('conexao.php');

if (!isset($_SESSION['id_u'])) {
  header('Location: login.php');
  exit();
}

if (isset($_POST['adicionar_carrinho'])) {
  $produto_id = $_POST['produto_id'];
  $quantidade = $_POST['quantidade'];
  $usuario_id = $_SESSION['id_u'];
  $status = 'pendente';

  $sql = "SELECT id_c, quantidade FROM carrinho WHERE usuario_id = ? AND produto_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ii", $usuario_id, $produto_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $quantidade += $row['quantidade'];
    $id_carrinho = $row['id_c'];
    $sql = "UPDATE carrinho SET quantidade = ? WHERE id_c = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantidade, $id_carrinho);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $_SESSION['mensagem'] = "Quantidade atualizada com sucesso!";
    } else {
      $_SESSION['mensagem'] = "Erro ao atualizar quantidade no carrinho.";
    }
  } else {
    $sql = "INSERT INTO carrinho (usuario_id, produto_id, quantidade, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $usuario_id, $produto_id, $quantidade, $status);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
      $_SESSION['mensagem'] = "Produto adicionado ao carrinho com sucesso!";
    } else {
      $_SESSION['mensagem'] = "Erro ao adicionar produto ao carrinho.";
    }
  }
}

header('Location: cardapio.php');
exit();
?>
