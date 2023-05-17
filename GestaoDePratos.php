<?php
require_once ("BackEnd/crudpratos.php");
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.7, maximum-scale=1.0, user-scalable=0">

    <link rel="stylesheet" type="text/css" href="Style/stylecrudprat.css" media="screen" />
    <title>Gestão de Pratos</title>
</head>
<body>  

    <div class="crudbox">
    <a href="GestorDirect.php" id="btnVoltar"><img src="Icons/back.png" alt="Voltar"></a>
    <div class="form-container">
        <form id="form-add" action="" method="post" enctype="multipart/form-data">
            <h2>Adicionar Prato</h2> 
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="Nome" required><br><br>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="Descricao" required></textarea>
            <label for="preco">Preço:</label>
            <input type="number" id="preco" name="Preco" step="0.01" required><br><br>
            <label for="tipo">Tipo:</label>
            <select id="tipo" name="Tipo" required>
                <option value="Comida">Comida</option>
                <option value="Bebida">Bebida</option>  
                <option value="Sobremesa">Sobremesa</option>
                <option value="Indisponivel">Indisponivel</option>
            </select><br><br>
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="Foto" accept="image/jpeg" required>
            <input type="submit" value="Adicionar">
        </form>

        <form id="form-edit" style="display:none" action="" method="post" enctype="multipart/form-data">
            <h2>Editar Prato</h2>
            <a href="#" onclick="history.back();" id="btnVoltar"><img src="Icons/back.png" alt="Voltar"></a>
            <label for="nome_edit">Nome:</label>
            <input type="text" id="nome_edit" name="Nome_edit" required><br><br>
            <label for="descricao_edit">Descrição:</label>
            <textarea id="descricao_edit" name="Descricao_edit" required></textarea>
            <label for="preco_edit">Preço:</label>
            <input type="number" id="preco_edit" name="Preco_edit" step="0.01" required><br><br>
            <label for="tipo_edit">Tipo:</label>
            <select id="tipo_edit" name="Tipo_edit" required>

<option value="Comida">Comida</option>
                <option value="Bebida">Bebida</option>
                <option value="Sobremesa">Sobremesa</option>
                <option value="Indisponivel">Indisponivel</option>
            </select><br><br>
            <label for="foto_edit">Foto:</label>
            <input type="file" id="foto_edit" name="Foto_edit" accept="image/jpeg">
            <input type="submit" value="Editar / Salvar">
            <input type="hidden" id="id_edit" name="id_edit">
        </form>
    </div>
    <br><br>
<div class="table-container">
    <table>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Tipo</th>
            <th>Foto</th>
            <th>Ações</th>
        </tr>
        <tbody>
                <?php while ($prato = mysqli_fetch_assoc($pratos)) { ?>
                <tr>
                    <td><?php echo $prato['Nome']; ?></td>
                    <td><?php echo $prato['Descricao']; ?></td>
                    <td>R$ <?php echo number_format($prato['Preco'], 2, ',', '.'); ?></td>
                    <td><?php echo $prato['Tipo']; ?></td>
                    <td><img src="Images/<?php echo $prato['Foto']; ?>" alt="<?php echo $prato['Nome']; ?>"  width = "200px" height = "150px"></td>
                    <td>
           <button onclick="editarPrato('<?php echo $prato['id']; ?>', '<?php echo $prato['Nome']; ?>', '<?php echo $prato['Descricao']; ?>', 
              '<?php echo $prato['Preco']; ?>', '<?php echo $prato['Tipo']; ?>')">Alterar</button>
                        <form action="" method="post">
                            <input type="hidden" name="id_remover" value="<?php echo $prato['id']; ?>">
                            <input type="submit" value="Remover">
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
</div>
</div>
</body>
</html>
<script>
function editarPrato(id, nome, descricao, preco, tipo) {
    document.getElementById("form-add").style.display = "none";
    document.getElementById("form-edit").style.display = "block";
    document.getElementById("nome_edit").value = nome;
    document.getElementById("descricao_edit").value = descricao;
    document.getElementById("preco_edit").value = preco;
    document.getElementById("tipo_edit").value = tipo;
    document.getElementById("id_edit").value = id;
}

</script>