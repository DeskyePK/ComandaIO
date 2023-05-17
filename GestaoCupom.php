<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <link rel="stylesheet" type="text/css" href="Style/stylecupom.css" media="screen" /> 
    <title>Adicionar Cupom</title>
	<style>
		#btnVoltar img {
		width: 50px;
		height: 50px;
		position: fixed;
		top: 10px;
		left: 10px;
		}
	</style>
</head>
<body>
	<a href="GestorDirect.php" id="btnVoltar"><img src="Icons/back.png" alt="Voltar"></a>
	<h1>Adicionar Cupom</h1>
	<form method="POST">

	<?php
	// Incluindo arquivo de conexão com o banco de dados
	require_once 'BackEnd/conexao.php';

	// Verificando se o formulário foi enviado
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		$codigo = $_POST['codigo'];
		$valor = $_POST['valor'];
		$data_validade = $_POST['data_validade'];
		$quantidade = $_POST['quantidade'];

		// Verificando se o código do cupom já existe no banco de dados
		$query = "SELECT * FROM cupons WHERE codigo = '$codigo'";
		$resultado = mysqli_query($conn, $query);

		if (mysqli_num_rows($resultado) > 0) {
			echo '<p style="color: red;">O código do cupom já existe!</p>';
		} else {
			// Inserindo o novo cupom no banco de dados
			$query = "INSERT INTO cupons (codigo, valor, data_validade, quantidade) VALUES ('$codigo', $valor, '$data_validade', $quantidade)";
			if (mysqli_query($conn, $query)) {
				echo '<p style="color: green;">Cupom adicionado com sucesso!</p>';
			} else {
				echo '<p style="color: red;">Erro ao adicionar cupom!</p>';
			}
		}
	}
	?>
	
		<label>Código do cupom:</label>
		<input type="text" name="codigo" required><br><br>

		<label>Valor do desconto:</label>
		<input type="number" name="valor" min="0" step="0.01" required><br><br>

		<label>Data de validade:</label>
		<input type="date" name="data_validade" required><br><br>

		<label>Quantidade:</label>
		<input type="number" name="quantidade" min="1" required><br><br>

		<button type="submit">Adicionar Cupom</button>
		<button type="button" onclick="window.location.href='cuponsadd.php'">Ver cupons adicionados</button>
	</form>

</body>
</html>
