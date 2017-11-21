<?php	
	require_once("phpmailer/class.phpmailer.php");
	define('GUSER', 'ouvidoria.ime@gmail.com');	// <-- Insira aqui o seu GMail
	define('GPWD', 'webmaster123');		// <-- Insira aqui a senha do seu GMail
	
	function smtpmailer($para, $de, $de_nome, $assunto, $corpo) { 
		global $error;
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';
		$mail->IsSMTP();		// Ativar SMTP
		$mail->SMTPDebug = 0;		// Debugar: 1 = erros e mensagens, 2 = mensagens apenas
		$mail->SMTPAuth = true;		// Autenticação ativada
		$mail->SMTPSecure = 'tls';	// TLS REQUERIDO pelo GMail
		$mail->Host = 'smtp.gmail.com';	// SMTP utilizado
		$mail->Port = 587;  		// A porta 587 deverá estar aberta em seu servidor
		$mail->Username = GUSER;
		$mail->Password = GPWD;
		$mail->SetFrom($de, $de_nome);
		$mail->Subject = $assunto;
		$mail->Body = $corpo;
		$mail->AddAddress($para);
		if(!$mail->Send()) {
			$error = 'Mail error: '.$mail->ErrorInfo; 
			return false;
		} else return true;
	}
	$corpo = "E-mail: ".$_POST["email"]."\n"."Nome: ".$_POST["nome"]."\nMensagem: ".$_POST['mensagem'];
	$email = "lucastefan9@gmail.com";
	if (smtpmailer($email, GUSER, 'Ouvidoria IME-USP', 'Mensagem da ouvidoria', $corpo)) {
		$message = 'Mensagem enviada com sucesso!';
	}
	require('template.php');
?>