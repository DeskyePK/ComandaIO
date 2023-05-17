<?php  
require_once("BackEnd/login.php");
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content= "width=device-width, user-scalable=no">
   <link rel="stylesheet" type="text/css" href="Style/style.css" media="screen" />
   <script src="Script\index.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" href="Style/style.css">
   <title>ComandaIO</title>
</head>
<body>
   
   <div class="LoginBox">
   <img src="Images\Logo.png" alt="Logo.png"></img>
   <br>
   <form action="BackEnd\login.php" method="post">
      
   <div class="input-group">
           <span class="input-group-addon">
               <i class="glyphicon glyphicon-user"></i>
           </span>
           <input class="dados" type="text" id="Usuario" placeholder="Usuário" name="Usuario">
       </div>
       <br><br>

       <div class="input-group">
           <span class="input-group-addon">
               <i class="glyphicon glyphicon-lock"></i>
           </span>
           <input class="dados" type="password" id="Senha" placeholder="Senha" name="Senha">
       </div>
       <br><br>
       
       <button type="submit" class="button-big">Entrar</button>
       <br><br>
       <?php
           if (isset($_SESSION['erro_login']) && $_SESSION['erro_login'] === true) {
               echo '<div class="error-message">Usuário ou senha inválidos</div>';
               unset($_SESSION['erro_login']);
           }
       ?>
   </form>
   </div>
</body>
</html>
