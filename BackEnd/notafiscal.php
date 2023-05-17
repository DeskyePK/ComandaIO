<?php
session_start();
require_once("conexao.php");
$id_usuario = $_SESSION['id_u'];

$query = "SELECT c.id_c, p.Nome, p.Preco, c.quantidade, (p.Preco * c.quantidade) AS Subtotal
          FROM carrinho c
          JOIN pratos p ON c.produto_id = p.id
          WHERE c.usuario_id = $id_usuario";
$resultado = mysqli_query($conn, $query);
$pretotal = 0;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Nota Fiscal</title>
	<link rel="stylesheet" type="text/css" href="nome_do_seu_arquivo.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>Nota Fiscal</h1>
			<p>Empresa: COMANDA.IO</p>
		</div>
		<div class="content">
			<table>
				<tr>
					<th>Produto</th>
					<th>Preço</th>
					<th>Quantidade</th>
					<th>Subtotal</th>
				</tr>
				<?php while ($linha = mysqli_fetch_assoc($resultado)) {
				    $nome_produto = $linha['Nome'];
				    $preco_produto = $linha['Preco'];
				    $quantidade = $linha['quantidade'];
				    $subtotal = number_format($linha['Subtotal'], 2, '.'); 
				    $pretotal += $linha['Subtotal'];
				    ?>
					<tr>
						<td><?= $nome_produto ?></td>
						<td>R$ <?= $preco_produto ?></td>
						<td><?= $quantidade ?></td>
						<td>R$ <?= $subtotal ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td colspan="3">Total:</td>
					<td>R$ <?= number_format($pretotal, 2, '.') ?></td>
				</tr>
			</table>
		</div>
		<div class="footer">
			<p>Impresso em: <?php echo date("d/m/Y H:i:s"); ?></p>
		</div>
	</div>
</body>
</html>

