<?php

	require_once('crud_user.php');
	require_once('mail.php');
	session_start();

	$html_text = "";

	if (isset($_POST['resent']) && isset($_SESSION['emailcode']) && isset($_SESSION['email']))
	{
		$user = getUserByEmail($mysqli, $_SESSION['email']);

		//$html_text.= "<a href='".$_SESSION['emailcode']."'>{$_SESSION['emailcode']}</a><br>";
		sendActivationEmail($user["email"], $user["name"], $_SESSION['emailcode'], $server_base_url);

		$html_text.= "Email sent again!<br><br>
		
					<form method = 'post' action = 'activate_user.php'>
						<input type = 'submit' name=resent value='Re-send email'>
					</form>";
	}
	else
	{
		if (isset($_GET['u']) && isset($_GET['c']))
		{
			$user = getUserByID($mysqli, $_GET['u']);
			if ($user)
			{
				if ($user["validation"] == $_GET['c'])
				{
					updateUserValidationByID($mysqli, $_GET['u'], 0);
					activateUserByID($mysqli, $_GET['u'], true);

					$html_text.= "<p> Congratulations! Your account has been activated. Now, please log in: </p><br><br>

						<form method = 'post' action = 'login.php'>
							<input type = 'submit' name = 'input' value = 'LOG IN'>
						</form>";
				}
				else if ($user["activated"])
				{
					$html_text.= "The account is already activated.";
				}
				else
				{
					$id = $user["user_id"];
					$val = $user["validation"];
					$_SESSION['emailcode'] = $server_base_url."activate_user.php?u={$id}&c={$val}";
					$_SESSION['email'] = $user["email"];
					$html_text.= "Sorry, that link does not work anymore. Try re-sending the email:<br><br>
						<form method = 'post' action = 'activate_user.php'>
							<input type = 'submit' name=resent value='Re-send email'>
						</form>";
				}
			}
			else
			{
				$html_text.= "The link is wrong. Please, try and register again!";
			}
		}
		else
		{
			$html_text.= "The link is wrong. Please, try and register again!";
		}
	}

	echo startAndEndHTML($server_base_url, "Activation", $html_text, false);
?>