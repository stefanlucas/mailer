<?php

// OBS: Cada variável no PHP é precedida do símbolo $


//-----------PARTE 1: RECEBENDO OS VALORES DO FORMULÁRIO E FAZENDO O TRATAMENTO PRÉVIO-----------//

// Recebe as variáveis do formulário via POST
$nome  			= $_POST["nome"];
$email   		= $_POST["email"];
$mensagem		= $_POST["mensagem"];

if ($nome == ""){
	$nome = "amigo(a)";
}
else{
	$nome = $nome;
}
//----------------------------------------FIM DA PARTE 1-----------------------------------------//


//--------------------------------PARTE 2: CONFIGURAÇÕES INICIAIS--------------------------------//

$email_destinatario = "ouvidoria.ime@gmail.com"; //"ouvidor@ime.usp.br";// E-mail destinatário
$assunto_destinatario = "Ouvidoria IME-USP | Novo contato ";// Assunto da mensagem do destinatário
$assunto_remetente = "Ouvidoria IME-USP | Retorno automático";// Assunto da resposta automática

// Acertando a acentuação
//$assunto_destinatario = utf8_decode($assunto_destinatario);
//$assunto_remetente = utf8_decode($assunto_remetente);

// Cabeçalhos p/ reconhecimento do HTML e do e-mail do destinatário
$headers = "MIME-Version: 1.1\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: $email_destinatario\r\n";

// Cabeçalhos p/ reconhecimento do HTML e do e-mail do remetente
$headers1 = "MIME-Version: 1.1\r\n";
$headers1 .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers1 .= "From: $email\r\n";

$data = date("d/m/y");// Data do envio
$hora = date("H:i");// Hora do envio

//----------------------------------------FIM DA PARTE 2-----------------------------------------//


//-------------PARTE 3: MONTANDO O CORPO DO E-MAIL PARA O DESTINATÁRIO E REMETENTE--------------//

// Corpo do e-mail enviado ao destinatário
$corpo = "<html> <head></head><body>
<font face=\"Courier New\">NOME.....................: </font> ".$nome."<br />
<font face=\"Courier New\">E-MAIL...................: </font> ".$email."<br />
<font face=\"Courier New\">MENSAGEM.................: </font> ".$mensagem."<br /><br />
<font face=\"Courier New\">DATA.....................: </font> ".$data."<br />
<font face=\"Courier New\">HORA.....................: </font> ".$hora."<br />
</body></html>";

// Corpo do e-mail da resposta automática
$resposta = "<html> <head></head><body>
<font face=\"Courier New\">Ol&aacute; </font>".$nome."
<font face=\"Courier New\">!</font><br/><br/>
<font face=\"Courier New\">Obrigado pela mensagem, em breve entraremos em contato. 
</body></html>";

$corpo 	= utf8_decode($corpo);
$resposta = utf8_decode($resposta);

//----------------------------------------FIM DA PARTE 2-----------------------------------------//


//----------------------------------------PARTE 4: ENVIO-----------------------------------------//

//$teste_telefone = preg_replace("'-'", "", $telefone);

// Verifica se os campos foram preenchidos
if (($email == "") || ($mensagem == "")) {
	echo "Verifique os campos obrigat&oacute;rios.";
}
// Verifica se o email é válido
//else if (!eregi("^[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\-]+\.[a-z]{2,4}$", $email)) {
//	echo "Digite um email v&aacute;lido";
//} 

else {
	
	//E-mail de auto-resposta para o destinatário
	mail($email_destinatario,$assunto_destinatario,$corpo,"$headers1");
	
	// E-mail de auto-resposta para o remetente
	mail($email,$assunto_remetente,$resposta,"$headers");

}

//----------------------------------------FIM DA PARTE 4-----------------------------------------//
?>
