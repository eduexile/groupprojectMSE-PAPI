<?php

	require_once('crud_user.php');
	require_once('crud_session.php');
	session_start();

	$html_text = "";
	$loggedIn = false;

	if (isset($_SESSION['login']))
	{
		if (getSessionByID($mysqli, $_SESSION['login']))
		{
			$loggedIn = true;
			$html_text.= "<p> Logged in. Loading your page now... </p>
			<br><br>
			<form method = 'post' action = 'logout.php'>
							<input type = 'submit' value = 'LOG OUT'>
						</form>";
			header("Location: $server_base_url");
		}
		else
		{
			$nextPage = $server_base_url."logout.php";
			header("Location: $nextPage");
		}
	}
	else
	{
		if (isset($_POST['email']) && strlen($_POST['email']) > 0)
		{
			if (isset($_POST['password']) && strlen($_POST['password']) > 0)
			{
				$activated = false;
				$loggedIn = areEmailAndPasswordValid($mysqli, $_POST['email'], $_POST['password'], $activated);
				if ($loggedIn)
				{
					$user = getUserByEmail($mysqli, $_POST['email']);
					if ($activated)
					{
						$session_id = insertSession($mysqli, $user["user_id"]);
						$_SESSION['login'] = $session_id;
						$html_text.= "<p> Logging in. </p>";

						$nextPage = $server_base_url."login.php";
						header("Location: $nextPage");
					}
					else
					{
						$id = $user["user_id"];
						$val = $user["validation"];
						$email_url = $server_base_url."activate_user.php?u={$id}&c={$val}";
						$_SESSION['emailcode'] = $email_url;
						$_SESSION['email'] = $_POST['email'];
						$html_text.= "<p> Please, activate your account first. </p><br>
						<form method = 'post' action = 'new_user.php'>
							<input type = 'submit' name=resent value='Re-send email'>
						</form><br><br>";
					}
				}
				else
				{
					$html_text.= "<p> Wrong email or password. Try again. </p>";
				}
			}
			else
			{
				$html_text.= "<p> Please insert a valid password. </p>";
			}
		}
		else if (isset($_POST['password']) && strlen($_POST['password']) > 0)
		{
				$html_text.= "<p> Please insert a valid mail. </p>";
		}

		if (!$loggedIn)
		{
			$html_text.= "<p> **** LOG IN **** </p>
					<form method = 'post' action = 'login.php'>
						<label> Email: </label>	
				    	<input type = 'text' name = 'email' placeholder = 'youremail@example.com'>
						<br><br>
						<label> Password: </label>
						<input type = 'password' name = 'password'  placeholder = '1234password'>	
						<br>
						<br>
						<input type='submit' value='Login'>				
					</form>
					<br>
					";
		}
	}

	echo startAndEndHTML($server_base_url, "Log in", $html_text, false);

?>