<?php
session_start();
require_once("BackEnd/conexao.php");
$id_usuario = $_SESSION['id_u'];

if (isset($_POST['cpf']) && isset($_POST['cupom'])) {
    $cpf = $_POST['cpf'];
    $cupom = $_POST['cupom'];

    // Verificar se o cupom está válido
    $query = "SELECT * FROM cupons WHERE codigo = '$cupom' AND quantidade > 0 AND data_validade >= CURDATE()";
    $resultado = mysqli_query($conn, $query);

    if (mysqli_num_rows($resultado) > 0) {
        // Cupom válido, prosseguir com o desconto
        $cupom_data = mysqli_fetch_assoc($resultado);
        $valor_cupom = $cupom_data['valor'];

        // Verificar se o mesmo CPF já utilizou o cupom anteriormente
        $query = "SELECT * FROM cupons_utilizados WHERE cpf = '$cpf' AND codigo_cupom = '$cupom'";
        $resultado = mysqli_query($conn, $query);

        if (mysqli_num_rows($resultado) == 0) {
            // CPF ainda não utilizou o cupom, prosseguir com o desconto

            // Atualizar a quantidade de cupons disponíveis
            $nova_quantidade = $cupom_data['quantidade'] - 1;
            $query = "UPDATE cupons SET quantidade = $nova_quantidade WHERE codigo = '$cupom'";
            mysqli_query($conn, $query);

            // Inserir o registro de utilização do cupom
            $query = "INSERT INTO cupons_utilizados (cpf, codigo_cupom, data_utilizacao) VALUES ('$cpf', '$cupom', NOW())";
            mysqli_query($conn, $query);

            $_SESSION['desconto'] = $valor_cupom; // salvar o valor do cupom na sessão

            $_SESSION['mensagem'] = "Desconto aplicado com sucesso!";

        } else {
            $_SESSION['mensagem'] = "Este CPF já utilizou este cupom anteriormente.";
            header('Location: cardapio.php');
            exit;
        }
    } else {
        $_SESSION['mensagem'] = "Cupom inválido ou expirado.";
    }
}

header("Location: ./carrinho.php");
exit();
?>