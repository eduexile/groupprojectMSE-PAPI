<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;

	require_once 'PHPMailer-master/src/PHPMailer.php';
	require_once 'PHPMailer-master/src/SMTP.php';
	require_once 'PHPMailer-master/src/Exception.php';

	function sendEmail(string $destination, string $destinationName, string $subject, string $message)
	{
		$mail = new PHPMailer;

		$mail->isSMTP();
		$mail->SMTPDebug = SMTP::DEBUG_OFF;
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 587;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->SMTPAuth = true;

		$mail->Username = 'ecebolleropapi20@gmail.com';
		$mail->Password = 'passwordpapi2020';
		$mail->setFrom('no_reply@Chueca-Veron-Cebollero.com', 'NO REPLY Chueca-Veron-Cebollero');

		$mail->addAddress($destination, $destinationName);

		$mail->Subject = $subject;

		$mail->msgHTML($message);
		$mail->AltBody = $message;
	
		if (!$mail->send())
		{
		    return false;
		}
		else 
		{
		    return true;
		}
	}

	function sendActivationEmail(string $destination, string $destinationName, string $activationURL, string $baseURL)
	{
		$subject = "Welcome to Chueca-Veron-Cebollero, ".$destinationName;
		$message = "Hello, ".$destinationName."!<br><br>
		The last step for being able to explore Chueca-Veron-Cebollero is right now! <br>
		Click <a href='".$activationURL."'>HERE</a> for finally activating your account. <br><br>
		If the link is not working, try copying this link and pasting it in your explorer's directions bar:<br>
		<a href='".$activationURL."'>{$activationURL}</a><br><br>
		Thanks a lot for trusting us, <br><br>
		<a href='".$baseURL."'>Chueca-Veron-Cebollero</a>";
		return sendEmail($destination, $destinationName, $subject, $message);
	}

	function sendNewEmailEmail(string $destination, string $destinationName, string $activationURL, string $baseURL)
	{
		$subject = "New email for Chueca-Veron-Cebollero, ".$destinationName."?";
		$message = "Hello, ".$destinationName."!<br><br>
		If you changed your email, click the link below to update it. If you did not ask for this message, you can ignore it. <br>
		<a href='".$activationURL."'>ACTIVATE EMAIL</a><br><br>
		If the link is not working, try copying this link and pasting it in your explorer's directions bar:<br>
		<a href='".$activationURL."'>{$activationURL}</a><br><br>
		Thanks a lot for trusting us, <br><br>
		<a href='".$baseURL."'>Chueca-Veron-Cebollero</a>";
		return sendEmail($destination, $destinationName, $subject, $message);
	}

?>
