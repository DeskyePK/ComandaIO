<?php
require_once ("BackEnd/cardapiolist.php");
if (!isset($_SESSION['Usuario']) || $_SESSION['Nivel'] != 2) {
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
    <link rel="stylesheet" type="text/css" href="Style/stylecardapio.css" media="screen" />  
    <title>Cardapio.IO</title>
</head>
<style>
    #alert {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #333;
    color: #fff;
    padding: 10px;
    border-radius: 5px;
    z-index: 9999;
    transition: opacity 0.3s ease-in-out;
  }
  
  #alert.show {
    opacity: 1;
  }
  
  #alert.hide {
    opacity: 0;
    display: none;
  }

  </style>
<body>
<div id="alert" style="display: none; color: white;"></div>
<?php if (isset($_SESSION['mensagem'])): ?>
<script src="Script/Cardapioadd.js"></script>
<script>

if (window.history.pushState) {
  window.history.pushState(null, null, window.location.href);
  window.onpopstate = function(event) {
    window.history.pushState(null, null, window.location.href);
  };
}

var alertDiv = document.getElementById("alert");
alertDiv.innerHTML = "<?php echo $_SESSION['mensagem'] ?>";
alertDiv.style.display = "block";
setTimeout(function() {
  alertDiv.style.display = "none";
}, 3000);
</script>
<?php unset($_SESSION['mensagem']); ?>
<?php endif; ?>
</body>
</html>
