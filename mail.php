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

		$mail->Username = 'help.munchking@gmail.com';
		$mail->Password = 'munchies2-';
		$mail->setFrom('no_reply@munchking.com', 'NO REPLY Munchking');

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
		$subject = "Welcome to Munchking, ".$destinationName;
		$message = "Hello, ".$destinationName."!<br><br>
		The last step for being able to explore Munchking is right now! <br>
		Click <a href='".$activationURL."'>HERE</a> for finally activating your account. <br><br>
		If the link is not working, try copying this link and pasting it in your explorer's directions bar:<br>
		<a href='".$activationURL."'>{$activationURL}</a><br><br>
		Thanks a lot for trusting us, <br><br>
		<a href='".$baseURL."'>Munchking</a>";
		return sendEmail($destination, $destinationName, $subject, $message);
	}

	function sendForgottenPasswordEmail(string $destination, string $destinationName, string $activationURL, string $baseURL)
	{
		$subject = "Forgot your password in Munchking, ".$destinationName."?";
		$message = "Hello, ".$destinationName."!<br><br>
		If you forgot your password, click the link below to update it and recover your account. If you did not ask for this message, you can ignore it. <br>
		<a href='".$activationURL."'>RECOVER ACCOUNT</a><br><br>
		If the link is not working, try copying this link and pasting it in your explorer's directions bar:<br>
		<a href='".$activationURL."'>{$activationURL}</a><br><br>
		Thanks a lot for trusting us, <br><br>
		<a href='".$baseURL."'>Munchking</a>";
		return sendEmail($destination, $destinationName, $subject, $message);
	}

	function sendNewEmailEmail(string $destination, string $destinationName, string $activationURL, string $baseURL)
	{
		$subject = "New email for Munchking, ".$destinationName."?";
		$message = "Hello, ".$destinationName."!<br><br>
		If you changed your email, click the link below to update it. If you did not ask for this message, you can ignore it. <br>
		<a href='".$activationURL."'>ACTIVATE EMAIL</a><br><br>
		If the link is not working, try copying this link and pasting it in your explorer's directions bar:<br>
		<a href='".$activationURL."'>{$activationURL}</a><br><br>
		Thanks a lot for trusting us, <br><br>
		<a href='".$baseURL."'>Munchking</a>";
		return sendEmail($destination, $destinationName, $subject, $message);
	}

?>
