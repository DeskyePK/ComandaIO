<?php
require_once 'BackEnd/login.php';
require_once 'BackEnd/conexao.php';

// Consulta SQL para listar os itens dos pedidos
$sql = "SELECT pedidos.id_p, Usuarios.Usuario, pratos.Nome, pedidos.quantidade, pedidos.status
        FROM pedidos
        JOIN Usuarios ON Usuarios.id_u = pedidos.usuario_id
        JOIN pratos ON pratos.id = pedidos.produto_id AND pedidos.status = 'pendente'
        ORDER BY pedidos.id_p ASC";
$resultado = $conn->query($sql);

// Verifica se a consulta retornou algum resultado
if ($resultado->num_rows > 0) {
  // Exibe os resultados em uma tabela HTML
  echo "<table>";
  echo "<tr><th>ID Pedido</th><th>Mesa</th><th>Produto</th><th>Quantidade</th><th>Status</th><th>Enviar</th></tr>";
  while($row = $resultado->fetch_assoc()) {
    echo "<tr id=\"pedido_" . $row["id_p"] . "\">";
    echo "<td>" . $row["id_p"] . "</td>";
    echo "<td>" . $row["Usuario"] . "</td>";
    echo "<td>" . $row["Nome"] . "</td>";
    echo "<td>" . $row["quantidade"] . "</td>";
    echo "<td>" . $row["status"] . "</td>";
    echo "<td class=\"btn-container\"><button onclick=\"concluirPedido(" . $row["id_p"] . ")\">Concluir</button></td>";
    echo "</tr>";
  }
  echo "</table>";
} else {
  echo "<div class='nao'>";
  echo "<h1>Não há pedidos cadastrados</h1>";
  echo "<div>";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>