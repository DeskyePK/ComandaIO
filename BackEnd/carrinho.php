<?php
session_start();
require_once ("conexao.php");
$id_usuario = $_SESSION['id_u'];

if(isset($_POST['remover'])) {
    $id_carrinho = $_POST['item_id'];
    $query = "SELECT quantidade FROM carrinho WHERE id_c = $id_carrinho";
    $resultado = mysqli_query($conn, $query);
    $linha = mysqli_fetch_assoc($resultado);
    if (isset($linha) && isset($linha['quantidade'])) {
        $quantidade = $linha['quantidade'];
        if ($quantidade > 1) {
            $quantidade--;
            $query = "UPDATE carrinho SET quantidade = $quantidade WHERE id_c = $id_carrinho";
            mysqli_query($conn, $query);
        } else {
            $query = "DELETE FROM carrinho WHERE id_c = $id_carrinho";
            mysqli_query($conn, $query);
        }
    }
}

$query = "SELECT c.id_c, p.Nome, p.Preco, c.quantidade, (p.Preco * c.quantidade) AS Subtotal
          FROM carrinho c
          JOIN pratos p ON c.produto_id = p.id
          WHERE c.usuario_id = $id_usuario";
$resultado = mysqli_query($conn, $query);
echo '<ul>';
echo '<li><a href="./cardapio.php">Inicio</a></li>';
echo '</ul>';

echo "<table>";
echo "<tr><th>Produto</th><th>Preço</th><th>Quantidade</th><th>Subtotal</th><th>Editar</th></tr>";
$pretotal = 0;

while ($linha = mysqli_fetch_assoc($resultado)) {
    $id_carrinho = $linha['id_c'];
    $nome_produto = $linha['Nome'];
    $preco_produto = $linha['Preco'];
    $quantidade = $linha['quantidade'];
    $subtotal = number_format($linha['Subtotal'], 2, '.', ''); 
    $pretotal += $subtotal; // atualização da variável $pretotal
    echo "<tr><td>$nome_produto</td><td>R$ $preco_produto</td><td>x$quantidade</td><td>R$ $subtotal</td>";
    echo "<td><form method='post' action=''>
              <input type='hidden' name='item_id' value='$id_carrinho'>
              <button type='submit' id='removero' name='remover'>Remover</button>
          </form></td></tr>";
}

if (isset($_SESSION['desconto'])) {
    $desconto = $_SESSION['desconto'];
    
    // Faz o que for necessário com o valor do desconto
    echo "<h2 class='descontot'>O desconto aplicado foi de R$ " . ($desconto.'%');


$valordescont = ($desconto / 100) * $pretotal;
$total = number_format($pretotal, 2, '.', '') - ($valordescont); // atualização da variável $total
}else{
$total = number_format($pretotal, 2, '.', '');
}

echo "<tr><td colspan='3'>Total:</td><td>R$ $total </td><td></td></tr>";
echo "</table>";
echo "<br>";

if (mysqli_num_rows($resultado) > 0) {
    echo "<div class='botoes'>";
    echo "<form method='post' action='./finalizarpedido.php'>
              <input type='hidden' name='total' value='$total'>
              <button type='submit' class='finalizar-pedido'>Finalizar Pedido</button>
          </form>";
          echo"<form method='post' action=''>
    <button type='submit' name='limpar_carrinho'>Limpar Carrinho
</form>";
echo"</div>";
 echo "<button onclick='abrirPopUp()' class='desconto-button'>Clique aqui para aplicar desconto</button>";

 echo "<div id='pop-up' class='pop-up'>
         <div class='pop-up-content'>
             <span onclick='fecharPopUp()' class='pop-up-close'>&times;</span>
             <h2>Informe seu CPF e cupom de desconto</h2>
             <form method='post' action='./aplicardesconto.php'>
                 <label for='cpf'>CPF:</label>
                 <input type='text' id='cpf' name='cpf' required>
                 <br>
                 <label for='cupom'>Cupom:</label>
                 <input type='text' id='cupom' name='cupom' required>
                 <br>
                 <button type='submit' class='aplicar-desconto' >Aplicar desconto</button>
             </form>
         </div>
     </div>";


echo "<script>
     function abrirPopUp() {
         document.getElementById('pop-up').style.display = 'block';
     }
     function fecharPopUp() {
         document.getElementById('pop-up').style.display= 'none';
     }
     </script>";



if (isset($_POST['limpar_carrinho'])){
    $query = "DELETE FROM carrinho WHERE usuario_id = $id_usuario";
    mysqli_query($conn, $query);
    $_SESSION['mensagem'] = "Carrinho limpo com sucesso!";
    header("Location: cardapio.php");
    exit();
}
} else {
}

?>