<?php
require_once ("BackEnd/login.php");
require_once ("BackEnd/crud.php");
if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 3) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Style/stylecrud.css" media="screen" />
    <title>Gestao de Usuarios</title>
    </head>
   <body>
  
   <a href="GestorDirect.php" id="btnVoltar"><img src="Icons/back.png" alt="Voltar"></a>
 <div class="CrudBox">
    
   <h1>Adicionar Usuário</h1>
      <form action="" method="post">
    Usuário: <input type="text" name="Usuario"><br><br>
    Senha: <input type="password" name="Senha"><br><br>
    Nível: 
    <select name="Nivel">
        <option value="1">Cozinha</option>
        <option value="2">Mesa</option>
    
    </select><br><br>
    <input type="submit" value="Adicionar">
    <input type="hidden" name="redirect" value="GestaoDeDados.php">
  </form>
    <h1>Usuários Cadastrados</h1>
    <table>
    <tr>
        <th>Usuário</th>
        <th>Nível</th>
        <th>Remover</th>
    </tr>

    <?php while($usuario = mysqli_fetch_array($usuarios)) { ?>
    <tr>
        <td><?php echo $usuario['Usuario']; ?></td>
        <td>
            <?php 
                if($usuario['Nivel'] == 1){
                    echo "Cozinha";
                }elseif($usuario['Nivel'] == 2){
                    echo "Mesa";
                }else{
                    echo "Gestor";
                }
            ?>
        </td>
        <td>
            <form action="" method="post">
                <input type="hidden" name="id_remover" value="<?php echo $usuario['id_u']; ?>">
                <input type="submit" value="Remover">
            </form>
        </td>
    </tr>
    <?php } 
    ?>
    </table>
 </div>
    </body>

</html>     