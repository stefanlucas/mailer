<?php
	$servername = "localhost";
	$username = "root";
	$password = "123456";
	$dbname = "ouvidoria";

	if (isset($_GET['email']) && !empty($_GET['email']) && isset($_GET['hash']) && !empty($_GET['hash'])) {
		try{
			$db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	    	// set the PDO error mode to exception
	    	$email = $_GET['email'];
	    	$hash = $_GET['hash'];
	    	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM user WHERE email = '$email' AND hash = '$hash'";
			$user = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
			if ($user != false) {
				$now = new DateTime(date("Y-m-d H:i:s"));
				$expiration_date = new DateTime($user['expiration_date']);
				if ($now->diff($expiration_date)->days >= 1 && $user['active'] == 0) {
					$error =  'Link expirado, insira seu e-mail para gerar outro link'."\n";
					require('mail_form.php');
					die();
				}
				if ($user['active'] == 0) {	
					$db->exec("UPDATE user SET active=1 WHERE email='$email' AND hash='$hash'");
					$message =  'E-mail validado com sucesso! Escreva a mensagem no formulário abaixo.';
				}
				else
					$message = 'Seu e-mail já foi validado anteriormente, escreva a mensagem no formulário abaixo.';
				$email = $_GET['email'];
   				require('message_form.php');
    			die();
			}	
		}	
		catch(PDOException $e)
		{
    		echo $e->getMessage();
		}
	}
	$error = "Link inválido, use o link que foi enviado no seu e-mail";
	require('template.php');

	$db = null;
?>