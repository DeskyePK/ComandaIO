<?php

require_once "BackEnd/conexao.php";
require_once 'vendor/autoload.php';


use Dompdf\Dompdf;
use PHPMailer\PHPMailer\PHPMailer;

$id_usuario = $_SESSION['id_u'];
$txgen = $_SESSION['txgen'];

$query = "SELECT c.id_c, p.Nome, p.Preco, c.quantidade, (p.Preco * c.quantidade) AS Subtotal
          FROM carrinho c
          JOIN pratos p ON c.produto_id = p.id
          WHERE c.usuario_id = $id_usuario";
$resultado = mysqli_query($conn, $query);
$pretotal = 0;



// Cria um objeto Dompdf
$dompdf = new Dompdf();

$html = '
<!DOCTYPE html>
<html>
<head>
	<title>Nota Fiscal</title>
	<style>
  body {
    font-size: 16px;
    margin: 0;
    padding: 0;
    background-color: #fff;
  }
  
  .container {
    width: 100%;
    max-width: 794px; /* largura da página A4 em pixels */
    margin: 0 auto;
    box-sizing: border-box;
    padding: 50px 30px;
    font-family: Arial, sans-serif;
    font-size: 14px;
  }
  
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
  }
  
  .header h1 {
    font-size: 24px;
    margin: 0;
  }
  
  .content table {
    width: 100%;
    max-width: 720px; /* ajuste a largura da tabela aqui */
    border-collapse: collapse;
    margin-top: 30px;
  }
  
  .content th,
  .content td {
    border: 1px solid #000;
    padding: 8px;
    text-align: center;
  }
  
  .content th {
    background-color: #ccc;
  }
  
  .content td:first-child {
    text-align: left;
  }
  
  .footer {
    text-align: center;
    margin-top: 40px;
  }
  
  .section {
    margin-bottom: 40px;
  }
  
  .section h2 {
    font-size: 18px;
    margin-bottom: 20px;
  }
  
  .section p {
    margin: 0;
  }
  
  .section p strong {
    font-weight: bold;
  }
  
  #nome_emitente,
  #endereco_emitente,
  #cnpj_emitente {
    display: inline-block;
    max-width: 400px; /* reduza a largura aqui */
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  
  #num_nf {
    font-weight: bold;
    font-size: 16px;
  }
  
  /* Estilo para os dados do emitente */
  #nome_emitente,
  #endereco_emitente,
  #cnpj_emitente {
    font-weight: bold;
  }
  
  section {
    margin: 30px 0px;
    page-break-inside: avoid;
  }
  
  footer {
    background-color: #000;
    color: #fff;
    text-align: center;
    padding: 20px;
    margin-top: 30px;
  }
  
  /* Estilo para impressão em A4 retrato */
  @media print {
    body {
      font-size: 12pt;
      width: 794px;
      height: 1123px;
      margin: 0;
      padding: 0;
      background-color: #fff;
    }
    
    .container {
      margin: 0;
      padding: 0;
      border: none;
      box-shadow: none;
      page-break-inside: avoid;
    }
    
    section {
      margin: 30px 0px;
      page-break-inside: avoid;
    }
  }
	</style>
</head>
<body>

<header>
<h1>NOTA FISCAL</h1>
<hr>
<p>Nº da Nota Fiscal: <span id="num_nf">'. $txgen .'</span></p>';
date_default_timezone_set('America/Sao_Paulo');
$html .= '
<p>Data de Emissão: <span id="data_emissao">'.date("d/m/Y H:i:s").'</span></p>
</header>
<section>
<h2>Dados do Emitente</h2>
<p><strong>Nome/Razão Social:</strong>Comanda.IO <span id="nome_emitente"></span></p>
<p><strong>Endereço:</strong> <span id="endereco_emitente">Rua da Felicidade N-08</span></p>
<p><strong>CNPJ:</strong> <span id="cnpj_emitente">79.353.984/0001-44</span></p>
<hr>

		<div class="content">
			<table>
				<tr>
					<th>Produto</th>
					<th>Preço</th>
					<th>Quantidade</th>
					<th>Subtotal</th>
				</tr>';
while ($linha = mysqli_fetch_assoc($resultado)) {
    $nome_produto = $linha['Nome'];
    $preco_produto = $linha['Preco'];
    $quantidade = $linha['quantidade'];
    $subtotal = number_format($linha['Subtotal'], 2, '.'); 
    $pretotal += $linha['Subtotal'];
    
    $html .= '
				<tr>
					<td>'.$nome_produto.'</td>
					<td>R$ '.$preco_produto.'</td>
					<td>'.$quantidade.'</td>
					<td>R$ '.$subtotal.'</td>
				</tr>';
        date_default_timezone_set('America/Sao_Paulo');
}
if (isset($_SESSION['desconto'])) {
  $desconto = $_SESSION['desconto'];

$valordescont = ($desconto / 100) * $pretotal;

$total = number_format($pretotal, 2, '.', '') - ($valordescont);

$html .= '
				<tr>
					<td colspan="3">Total com desconto:</td>
					<td>R$ '.number_format($total, 2, '.').'</td>
				</tr>
			</table>
		</div>
	</div>
  </section>
	<footer>
		<p>Obrigado pela preferência!</p>
	</footer>
</body>

</html>';

}else{

$total = number_format($pretotal, 2, '.', '');

$html .= '
				<tr>
					<td colspan="3">Total:</td>
					<td>R$ '.number_format($total, 2, '.').'</td>
				</tr>
			</table>
		</div>
	</div>
  </section>
	<footer>
		<p>Obrigado pela preferência!</p>
	</footer>
</body>

</html>';
}


$dompdf->loadHtml($html);

// Define as opções de renderização e renderiza o PDF
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Define o nome do arquivo PDF
$nome_arquivo = 'NF-E/nota_fiscal_'.$id_usuario.'_'.uniqid('', true).'.pdf';

// Renderiza o PDF e obtém o conteúdo como uma string
$dompdf->render();
$pdf_content = $dompdf->output();

// Salva o conteúdo do PDF em um arquivo no servidor
file_put_contents($nome_arquivo, $pdf_content);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $_SESSION['email'];
  // PHPMailer nova instancia
  $mail = new PHPMailer;


  // Define o servidor SMTP e as credenciais de autenticação
  $mail->isSMTP();
  $mail->Host = 'smtp.gmail.com';
  $mail->SMTPAuth = true;
  $mail->Username = 'comandaiop@gmail.com';
  $mail->Password = 'krowarwqzcvtgwkv';
  $mail->SMTPSecure = 'tls'; // use 'ssl' se necessário
  $mail->Port = 587; // use 465 se usar 'ssl'


  // Define o remetente e o destinatário do e-mail
  $mail->setFrom('comandaiop@gmail.com', 'ComandaIO');
  $mail->addAddress($email);

  // Define o assunto e o corpo do e-mail
  $mail->Subject = 'Comprovante de Compra ComandaPay';
  $mail->Body = 'Olá, Segue em anexo a nota fiscal. Atenciosamente, ComandaPay';

  // Define o nome e o conteúdo do arquivo anexo
  $file_path = $nome_arquivo;
  $file_name = basename($file_path);
  $file_content = file_get_contents($file_path);

  // Adiciona o arquivo anexo ao e-mail
  $mail->addStringAttachment($file_content, $file_name);



  if (!$mail->send()) {
    echo 'Ocorreu um erro no envio do email: ' . $mail->ErrorInfo;
  } else {
    
    $id_usuario = $_SESSION['id_u'];

    // Inserir os itens do carrinho na tabela de pedidos
    $query = "INSERT INTO pedidos (usuario_id, produto_id, quantidade, status)
              SELECT usuario_id, produto_id, quantidade, 'pendente'
              FROM carrinho
              WHERE usuario_id = $id_usuario;";
    mysqli_query($conn, $query);

    // Se o email foi enviado com sucesso, redireciona o usuário para a página de pedidos
    echo '<script>
    window.location.href = "cardapio.php";
    </script>';
    
  // Limpa a sessão txgen
  unset($_SESSION['txgen']);
  $query = "DELETE FROM carrinho WHERE usuario_id = $id_usuario";
  mysqli_query($conn, $query);

  unset($_SESSION['email']);

  if (isset($_SESSION['desconto'])) {
  unset($_SESSION['desconto']);
}
  }
}
?>
