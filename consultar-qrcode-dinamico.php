<?php
require __DIR__.'/vendor/autoload.php';
require_once 'BackEnd/login.php';



use \App\Pix\Api;
use \App\Pix\Payload;

// Obtém o valor da sessão txgen
$txgen = $_SESSION['txgen'];


// INSTANCIA DA API PIX
$obApiPix = new Api('https://api-pix.gerencianet.com.br',
'Client_Id_64e6f31f2f672731f5ac07ddcdb9314fde11c816',
'Client_Secret_e9fc70e039387ec4ebf571fccdcb0015afb7bd78',
 __DIR__. '/files/certificates/certificadoproducao.pem' );

// RESPOSTA DA REQUISIÇÃO DE CRIAÇÃO
$response = $obApiPix->consultCob($txgen); // Passa o valor da sessão txgen
// VERIFICA A EXISTÊNCIA DO ITEM 'LOCATION'
if(!isset($response['location'])){
  echo 'Problemas ao consultar Pix dinâmico';
}

// VERIFICA SE A TRANSAÇÃO FOI CONCLUÍDA COM SUCESSO
if($response['status'] != 'CONCLUIDA') {

  // Mostra a mensagem de sucesso e redireciona para o cardápio após 10 segundos
  echo '<html>
          <head>
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" type="text/css" href="Style/stylepagsucess.css" media="screen" />  
          </head>
          <body>
            <h1>Pagamento Realizado com Sucesso</h1>
            <form method="POST" action="">
              <label for="email">Email:</label>
              <input type="email" id="email" name="email" required>
              <button  type="submit" id="myButton" onclick="showLoading()">Enviar</button>
              <div id="loading" style="display:none">
  <div class="progress-bar">
    <div class="progress"></div>
  </div>
</div>
<div>
            </form>

            <p>Informe seu Email para o Envio do Comprovante Fiscal de compra e aguarde volta para o site...</p>
        
          </body>

          <script>
          function showLoading() {
            document.getElementById("myButton").style.display = "none";
            document.getElementById("loading").style.display = "block";
            
            var progressBar = document.querySelector(".progress");
            var percent = 0;
            var intervalId = setInterval(function() {
              percent += 10;
              progressBar.style.width = percent + "%";
              if (percent >= 100) {
                clearInterval(intervalId);
                window.location.href = "cardapio.php";
              }
            }, 500);
          }
    </script>
        </html>';

        // Verifica se o formulário foi enviado
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Atribui o valor do input a uma variável de sessão
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['mensagem'] = "A nota fiscal foi enviada para o seu email!";
  }
  
  require_once 'NotaFiscalTable.php';

  exit;
}else{
  // Limpa a sessão txgen e redireciona para a página de finalização do pedido
  unset($_SESSION['txgen']);
  header("Location: finalizarpedido.php");
  exit;
}

echo "<pre>";
print_r($response);
echo "</pre>"; 
exit;
