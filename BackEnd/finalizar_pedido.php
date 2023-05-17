<?php
session_start();
require_once ("conexao.php");
if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 2) {
    header("Location: index.php");
    exit;
}

$id_usuario = $_SESSION['id_u'];

if(isset($_POST['remover'])) {
    $id_carrinho = $_POST['item_id'];
    $query = "DELETE FROM carrinho WHERE id_c = $id_carrinho";
    mysqli_query($conn, $query);
}

$query = "SELECT c.id_c, p.Nome, p.Preco, c.quantidade, (p.Preco * c.quantidade) AS Subtotal
          FROM carrinho c
          JOIN pratos p ON c.produto_id = p.id
          WHERE c.usuario_id = $id_usuario";
$resultado = mysqli_query($conn, $query);
$total = 0;
while ($linha = mysqli_fetch_assoc($resultado)) {
    $id_carrinho = $linha['id_c'];
    $nome_produto = $linha['Nome'];
    $preco_produto = $linha['Preco'];
    $quantidade = $linha['quantidade'];
    $subtotal = floatval($linha['Subtotal']);
    $total += $subtotal;
 }

 if (isset($_SESSION['desconto'])) {
    $desconto = $_SESSION['desconto'];

  
    $desconto = ($desconto / 100) * $total;
    $total_com_desconto = $total - $desconto; 

 $formata_total =($total_com_desconto);

 $formata_total = number_format($formata_total, 2, '.', '');
 $total = number_format($formata_total, 2, '.', '');
 
 }else{

    $formata_total = number_format($total, 2, '.', '');
 }



?>
