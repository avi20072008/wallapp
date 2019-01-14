<?php 
	
	require_once('PHPMailer/src/PHPMailer.php');
	require_once('PHPMailer/src/SMTP.php');
	require_once('PHPMailer/src/Exception.php');

	// Add gmail username and password to $mail->Username and $mail->Password.
	class SendEmail
	{
		public function __construct($username, $email)
		{
			try{
				$mail = new PHPMailer\PHPMailer\PHPMailer(true);
				$mail->isSMTP();
				$mail->Mailer = 'smtp';
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'tls';
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;
				$mail->isHTML(true);
				$mail->Username = '********@gmail.com';
				$mail->Password = '********';
				$mail->setFrom('noreply@wallapp.com');
				$mail->Subject = 'Welcome to Wall App';
				$mail->Body = "Hi {$username}, <br/>Thanks for registring with Wall App.";
				$mail->AddAddress($email);
				$mail->send();

			}catch (phpmailerException $e) {
		  		echo $e->errorMessage(); //error messages from PHPMailer
			} catch (Exception $e) {
		  		echo $e->getMessage();
			}
		}
	}
 ?>