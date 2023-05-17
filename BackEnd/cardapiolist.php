<?php
session_start();
require_once("conexao.php");

if (isset($_GET['pesquisar'])) {
  $termo = $_GET['pesquisar'];
  $sql = "SELECT * FROM pratos WHERE Tipo = 'Comida' AND Nome LIKE '{$termo}%'";
} else {
  $sql = "SELECT * FROM pratos WHERE Tipo = 'Comida'";
}

$resultado = mysqli_query($conn, $sql);

if (mysqli_num_rows($resultado) >= 0) {
  echo '<ul>';
  echo '<li><a href="./cardapio.php">Inicio</a></li>';
  echo '<li><a href="./carrinho.php">Carrinho</a></li>';
  echo '<li><a href="./pedidos.php">Pedidos</a></li>';
  echo '<div class="topnav">';
  echo '<form method="get">';
  echo '<input type="text" id="pesquisar" name="pesquisar" placeholder="Pesquisa . . .">';
  echo '<button type="submit">Buscar</button>';
  echo '</form>';
  echo '</div>';
  echo '</ul>';

  echo '<div class="Pratos">';
  while ($pratos = mysqli_fetch_assoc($resultado)) {
    echo '<div class="bloco-pratos">';
    echo '<article class="menu-item">';
    echo '<img src="./Images/' . $pratos["Foto"] .'" alt="menu-item" class="photo">';
    echo '<div class="item-info">';
    echo '<header>';
    echo '<h4>'  . $pratos["Nome"] . '</h4>';
    echo '</header>';
    echo '<div class="item-text">';
    echo '<h4 class="price">R$ ' . number_format($pratos["Preco"], 2, ',', '.') . '</h4>';
    echo '<p>' . $pratos["Descricao"] . '</p>';
    echo ' </div>';
    echo '<div class="cotainerbutton">';
    echo '<form method="post" action="adicionar_carrinho.php">';
    echo '<input type="hidden" name="produto_id" value="' . $pratos["id"] . '">';
    echo '<div class="quantidade">';
    echo '<label for="quantidade">Quantidade:</label>';
    echo '<input type="number" id="quantidade" name="quantidade" min="1" max="10" value="1">';
    echo '</div>';
    echo '<button id="botao" type="submit" name="adicionar_carrinho">Adicionar ao carrinho</button>';
    echo '</form>';
    echo '</div>';
    echo '</article>';
    echo '</div>';
  }
  echo '</div>';
}

if (isset($_SESSION["id_u"])) {

} else {
  echo "Erro: Usuário não está logado.";
}
echo "<style>#botao{margin-left: -30px;}</style>";
mysqli_close($conn);
?>
