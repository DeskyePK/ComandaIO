<?php

//puxa a conexao
require_once("conexao.php");
// Insere usuário no banco
if(isset($_POST['Usuario']) && isset($_POST['Senha']) && isset($_POST['Nivel'])){
    $Usuario = $_POST['Usuario'];
    $Senha = $_POST['Senha'];
    $Nivel = $_POST['Nivel'];
    $query = "INSERT INTO Usuarios (Usuario, Senha, Nivel) VALUES ('$Usuario', '$Senha', '$Nivel')";
    $conn->query($query);
}

// redireciona
if (isset($_POST['redirect'])) {
    header("Location: " . $_POST['redirect']);
    exit;
}


// Remove usuário do banco
if(isset($_POST['id_remover'])){
    $id_u = $_POST['id_remover'];
    $sql_carrinho = "DELETE FROM carrinho WHERE usuario_id = '$id_u'"; //remove primeiro os registros da tabela carrinho
    mysqli_query($conn, $sql_carrinho);

    $sql_pedidos = "DELETE FROM pedidos WHERE usuario_id = '$id_u'"; //remove também os registros da table pedidos
    mysqli_query($conn, $sql_pedidos);

    $query = "DELETE FROM Usuarios WHERE id_u = '$id_u'"; //agora remove o usuário do banco
    $conn->query($query);
}

// Seleciona todos os usuários cadastrados mostra na lista
$query = "SELECT * FROM Usuarios WHERE Nivel = '2' || Nivel = '1'";
$usuarios = $conn->query($query);



?>
