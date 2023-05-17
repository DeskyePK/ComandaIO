<?php
session_start();

require_once ("conexao.php");

// Se o formulário de adição de prato foi enviado
if (isset($_POST['Nome']) && isset($_POST['Descricao']) && isset($_POST['Preco']) && isset($_POST['Tipo']) && isset($_FILES['Foto'])) {
    // Valida os dados do formulário
    $nome = mysqli_real_escape_string($conn, $_POST['Nome']);
    $descricao = mysqli_real_escape_string($conn, $_POST['Descricao']);
    $preco = floatval($_POST['Preco']);
    $tipo = mysqli_real_escape_string($conn, $_POST['Tipo']);
    $foto = $_FILES['Foto'];

    // Verifica se o arquivo de foto é válido
    if ($foto['error'] == UPLOAD_ERR_OK && $foto['type'] == 'image/jpeg') {
        // Move o arquivo para o servidor
        move_uploaded_file($foto['tmp_name'], './Images/' . $foto['name']);
        // Insere o prato no banco de dados
        $sql = "INSERT INTO pratos (Nome, Descricao, Preco, Tipo, Foto) VALUES ('$nome', '$descricao', '$preco', '$tipo', '$foto[name]')";
        mysqli_query($conn, $sql);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}
// Se o formulário de alteração de prato foi enviado
if (isset($_POST['id_edit']) && isset($_POST['Nome_edit']) && isset($_POST['Descricao_edit']) && isset($_POST['Preco_edit']) && isset($_POST['Tipo_edit'])) {
    $id_edit = mysqli_real_escape_string($conn, $_POST['id_edit']);
    $nome_edit = mysqli_real_escape_string($conn, $_POST['Nome_edit']);
    $descricao_edit = mysqli_real_escape_string($conn, $_POST['Descricao_edit']);
    $preco_edit = floatval($_POST['Preco_edit']);
    $tipo_edit = mysqli_real_escape_string($conn, $_POST['Tipo_edit']);

    if (isset($_FILES['Foto_edit']) && $_FILES['Foto_edit']['error'] == 0) {
        $arquivo_tmp = $_FILES['Foto_edit']['tmp_name'];
        $nome = $_FILES['Foto_edit']['name'];

        // Verifica se o arquivo de foto é válido
        if ($_FILES['Foto_edit']['type'] == 'image/jpeg') {
            // Move o arquivo para o servidor
            move_uploaded_file($arquivo_tmp, './Images/' . $nome);
            // Atualiza as colunas na tabela do banco de dados com a foto
            $sql = "UPDATE pratos SET nome='$nome_edit', descricao='$descricao_edit', preco='$preco_edit', tipo='$tipo_edit', foto='$nome' WHERE id='$id_edit'";
            $query = mysqli_query($conn, $sql);
            header('Location: ' . $__SERVER['PHP_SELF']);
            exit();
        }
    } else {
        // Atualiza as colunas na tabela do banco de dados sem a foto
        $sql = "UPDATE pratos SET nome='$nome_edit', descricao='$descricao_edit', preco='$preco_edit', tipo='$tipo_edit' WHERE id='$id_edit'";
        $query = mysqli_query($conn, $sql);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Se o formulário de remoção de prato foi enviado
if (isset($_POST['id_remover'])) {
    $id_remover = mysqli_real_escape_string($conn, $_POST['id_remover']);

    $sql_pedidos = "SELECT * FROM pedidos WHERE produto_id = $id_remover AND Status = 'Concluido'"; // verifica se o prato está em algum pedido
    $result_pedidos = mysqli_query($conn, $sql_pedidos);

    if (mysqli_num_rows($result_pedidos) == 0) {

        echo '<script>alert("O pedido não pode ser excluído porque não está concluído.");</script>';
        echo '<script>window.location.href = window.location.href;</script>';
        exit();

    } else {
        // Exclui os registros na tabela carrinho que fazem referência ao prato a ser excluído
        $sql_carrinho = "DELETE FROM carrinho WHERE produto_id = $id_remover";
        mysqli_query($conn, $sql_carrinho);

        $sql_carrinho = "DELETE FROM pedidos WHERE produto_id = $id_remover";
        mysqli_query($conn, $sql_carrinho);

        // Obtém o nome da imagem correspondente
        $sql_pratos = "SELECT foto FROM pratos WHERE id = $id_remover";
        $result = mysqli_query($conn, $sql_pratos);
        $row = mysqli_fetch_assoc($result);
        $foto = $row['foto'];

        $sql_pratos = "DELETE FROM pratos WHERE id = $id_remover";  // exclui o prato da tabela pratos
        $query = mysqli_query($conn, $sql_pratos);

        if ($query && !empty($foto) && file_exists('./Images/' . $foto)) { // exclui a imagem do servidor
            unlink('./Images/' . $foto);
        }

        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
       
    }
}



// Busca todos os pratos no banco de dados
$sql = "SELECT * FROM pratos";
$pratos = mysqli_query($conn, $sql);
?>