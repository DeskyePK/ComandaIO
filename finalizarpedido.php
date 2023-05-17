<?php
require_once 'BackEnd/finalizar_pedido.php';
?>

<!DOCTYPE html>
<html lang="pt-br"></html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/styleqrcode.css">
    <style>
.linkcopie {
  display: none;
}
 @media only screen and (max-width: 600px) {
    .linkcopie {
  display: block;
 }
}
        </style>
    <title>COMANDAPAY</title>
</head>
<body>
<div class="qrpay-container">
	<div class="logo-container">
		<img class="comandapay-logo"
			src="Images/comandapay.png">
	</div>
	<div class="content-container">
		<div class="payment-info">
			<div class="payment-info-panel">
				<div class="product-name">Bem Vindo!</div>
				<div class="product-description">Ao Sistema de Pagamentos Comanda.IO um ambiete seguro gerenciado pelo ComandaPay !
                   <br>
                    Não saia da página até que o pagamento seja feito !
                    <br>
                    Qualquer má utilizacao do sistema resultará em perda do seu pagamento !
                </div>
				<div class="costumer-profile">
					<img src="Images\Logo.png"
						alt="costumer-avatar" class="costumer-avatar">
					<div class="costumer-info">
						<div class="costumer-name">Comanda.IO</div>
						<div class="costumer-nickname">@Comanda.IO_OFICIAL</div>
					</div>
				</div>
			</div>
			<div class="instruction-container">
				<p>
					<b class="bold-text">Instruções:</b> <span class="normal-text">Já realizou o Pagamento ? clique no botao a baixo</span>
                   
				</p>
                <button onclick="window.location.href='consultar-qrcode-dinamico.php'">Finalizar Pagamento</button>
			</div>
		</div>
		<div class="payment-qrcode">
			<div class="payment-qrcode-panel">
				<div class="scan-msg">Escaneie o QRCode para efetuar o pagamento</div>
				<div class="payment-price">
					<span class="currency-sign">R$ </span>
					<span class="price"><?php echo " $total"; ?></span>
                    
				</div>
		<?php
        require __DIR__.'/vendor/autoload.php';
        
        use \App\Pix\Api;
        use \App\Pix\Payload;
        use Mpdf\QrCode\QrCode;
        use Mpdf\QrCode\Output;
        //Gerando o uniqid com 26-35 caracteres
        $txgen = uniqid('', true);
        $txgen = substr(str_replace(['+', '/', '='], '', base64_encode($txgen)), 0, rand(26, 35));

        $obApiPix = new Api('https://api-pix.gerencianet.com.br',
        'Client_Id_64e6f31f2f672731f5ac07ddcdb9314fde11c816',
        'Client_Secret_e9fc70e039387ec4ebf571fccdcb0015afb7bd78',
         __DIR__. '/files/certificates/certificadoproducao.pem' );

                             
        //CORPO DA REQUISIÇÃO
        $request = [
            'calendario' => [
                'expiracao' => 3600
            ],
            'devedor' => [
                'cpf' => '12746620448',
                'nome' => 'COMANDAPAY'
            ],
            'valor' => [
                'original' => $formata_total
            ],
            'chave' => 'deskyepk@gmail.com',
            'solicitacaoPagador' => 'ComandaPay'
        ];
                             
        //RESPOSTA DA REQUISIÇÃO DE CRIAÇÃO
        $response = $obApiPix->createCob($txgen, $request);

        if(!isset($response['location'])){
            echo 'Problemas ao gerar Pix Dinâmico';

        } else {
            $obPayload = (new Payload) 
                ->setMerchantName('COMANDAPAY')
                ->setMerchantCity('RECIFE')
                ->setAmount($total)
                ->setTxid('***')
                ->setUrl($response['location'])
                ->setUniquePayment(true);

                     
            $payloadQrCode = $obPayload ->getPayload();

            $obQrCode = new QrCode($payloadQrCode);
            $image = (new Output\Png)->output($obQrCode,500);

            // Exibindo o QR code na tela
            
            echo '<img src="data:image/png;base64,' . base64_encode($image) . '" style="width: 200px; height: 200px;">';
           // echo $payloadQrCode; chave pix na tela

            $_SESSION['txgen'] = $txgen; // Salva o txgen na sessão
           
        }
        ?>
    
          <button class="linkcopie" onclick="copyToClipboard('<?php echo $payloadQrCode; ?>')">Copiar Código</button>

     
       
		 </div>
</div>
        
 </div>
	<div class="footer-container">
		<p class="copyright-text">© 2023-2023 COMANDAPAY BRASIL. Todos os direitos reservados</p>
	</div>
</div>
<script>
function copyToClipboard(text) {
  var input = document.createElement('textarea');
  input.innerHTML = text;
  document.body.appendChild(input);
  input.select();
  document.execCommand('copy');
  document.body.removeChild(input);
}
</script>
</body>
</html>