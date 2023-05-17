<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="Style/stylecupom.css" media="screen" /> 
    <title>Cupons Adicionados</title>
    <style>
        th.column-name {
            padding-right: 20px;
        }
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
    <a href="GestaoCupom.php" id="btnVoltar"><img src="Icons/back.png" alt="Voltar"></a>
    <h1>Cupons Adicionados</h1>
    <form>
    <?php
    // Incluindo arquivo de conexão com o banco de dados
    require_once 'BackEnd/conexao.php';

    // Selecionando todos os cupons adicionados
    $query = "SELECT * FROM cupons";
    $resultado = mysqli_query($conn, $query);
    
    // Verificando se existem cupons adicionados
    if (mysqli_num_rows($resultado) > 0) {
        // Exibindo os cupons adicionados em uma tabela
        echo '<table>';
        echo '<tr>';
        echo '<th class="column-name">Código</th>';
        echo '<th class="column-name">Valor do Desconto</th>';
        echo '<th class="column-name">Data de Validade</th>';
        echo '<th class="column-name">Quantidade</th>';
        echo '</tr>';
        while ($cupom = mysqli_fetch_assoc($resultado)) {
            echo '<tr>';
            echo '<td>'. $cupom['codigo']. '</td>';
            echo '<td>'. $cupom['valor'].'%'.'</td>';
            echo '<td>'. date('d/m/Y', strtotime($cupom['data_validade'])). '</td>';
            echo '<td>'. $cupom['quantidade']. '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p>Nenhum cupom adicionado ainda.</p>';
    }
    ?>
    </form>
</body>
</html>
