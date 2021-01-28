<?php

	require_once('crud_user.php');
	require_once('crud_session.php');
	require_once('mail.php');

	session_start();

	$html_text = "";

	$proceed = true;

	if (isset($_SESSION['login']))
	{
		if (getSessionByID($mysqli, $_SESSION['login']))
		{
			$proceed = false;
			$session_id = $_SESSION['login'];
			$user_id = getSessionByID($mysqli, $_SESSION['login'])["user_id"];
			deleteSessionByID($mysqli, $session_id);
			$session_id = insertSession($mysqli, $user_id);
			$_SESSION['login'] = $session_id;

			header("Location: $server_base_url");

		}
		
	}

	if ($proceed)
	{
		$next_page = isset($_POST['name']) && isset($_POST['password']) && isset($_POST['second_password']) && isset($_POST['email']) && strlen($_POST['name']) > 0 && strlen($_POST['email']) > 0 && strlen($_POST['password']) > 0 && strlen($_POST['second_password']) > 0;
		$partially_completed = false;
		$completed_form = $next_page;

		if (isset($_POST['resent']) && isset($_SESSION['emailcode']) && isset($_SESSION['email']))
		{
			$user = getUserByEmail($mysqli, $_SESSION['email']);

			//$html_text.= "<a href='".$_SESSION['emailcode']."'>{$_SESSION['emailcode']}</a><br>";
			sendActivationEmail($user["email"], $user["name"], $_SESSION['emailcode'], $server_base_url);

			$html_text.= "Email sent again!<br><br>
			<p> Register completed! A confirmation has been sent to your email. <br><br>
					Please: before login in, check your email and click on the link we sent you for activating your account. </p> <br><br>

						<form method = 'post' action = 'new_user.php'>
							<input type = 'submit' name=resent value='Re-send email'>
						</form>";
		}
		else
		{
			if ($next_page)
			{
				if ($_POST['password'] != $_POST['second_password'])
				{
					$html_text.= "<p> Passwords don't match! </p><br>";
					$next_page = false;
				}
				else if (strlen($_POST['password']) > 64)
				{
					$html_text.= "<p> Passwords is greater than max size (64)! </p><br>";
					$next_page = false;
				}
				else
				{
					if (insertUser($mysqli, $_POST['name'], $_POST['email'], $_POST['password']))
					{
						$user = getUserByEmail($mysqli, $_POST['email']);
						$id = $user["user_id"];
						$val = $user["validation"];
						$email_url = $server_base_url."activate_user.php?u={$id}&c={$val}";
						$_SESSION['emailcode'] = $email_url;
						$_SESSION['email'] = $_POST['email'];

						//$html_text.= "<a href='".$email_url."'>{$email_url}</a><br>";
						sendActivationEmail($user["email"], $user["name"], $email_url, $server_base_url);

						$html_text.= "<p> Register completed! A confirmation has been sent to your email. <br><br>
						Please: before login in, check your email and click on the link we sent you for activating your account. </p> <br><br>

							<form method = 'post' action = 'new_user.php'>
								<input type = 'submit' name=resent value='Re-send email'>
							</form>";
					}
					else
					{
						$html_text.= "<p> Email already registered. Try again with another email or try to log in instead. </p><br>";
						$next_page = false;
					}
				}
			}

			if (!$next_page)
			{
				$html_text.="
							<p> **** REGISTER **** </p>
							<form method = 'post' action = 'new_user.php'>
								<label> Name: </label><br>";
				if (isset($_POST['name']) && strlen($_POST['name']) > 0)
				{
					$name = $_POST['name'];
					$partially_completed = true;
					$html_text.="<br><input type = 'text' name = 'name' value = '{$name}'><br>";
				}
				else
				{
					$html_text.="<br><input type = 'text' name = 'name' placeholder = 'John Smith'><br>";
				}

				$html_text.="<br><label> Email: </label><br>";
				if (isset($_POST['email']) && strlen($_POST['email']) > 0)
				{
					$email = $_POST['email'];
					$partially_completed = true;
					$html_text.="<br><input type = 'email' name = 'email' value = '{$email}'><br>";
				}
				else
				{
					$html_text.="<br><input type = 'email' name = 'email' placeholder = 'youremail@example.com'><br>";
				}

				$html_text.="<br><label> Password (max 64 characters): </label><br>";
				if (isset($_POST['password']) && strlen($_POST['password']) > 0)
				{
					$password = $_POST['password'];
					$partially_completed = true;
					$html_text.="<br><input type = 'password' name = 'password'  value = '{$password}'><br>";
				}
				else
				{
					$html_text.="<br><input type = 'password' name = 'password'  placeholder = '1234password'><br>";
				}

				$html_text.="<br><label> Repeat password (same one): </label><br>";
				if (isset($_POST['second_password']))
				{
					$partially_completed = true;
					$html_text.="<br><input type = 'password' name = 'second_password'><br>";
				}
				else
				{
					$html_text.="<br><input type = 'password' name = 'second_password'><br>";
				}

				$html_text.="<br><br><input type='submit' value='Register'>
							</form>
							<br>
							<p> Already have an account? </p>
							<form method = 'post' action = 'login.php'>
								<input type = 'submit' value = 'Log in instead'>
							</form>";
										
				if ($partially_completed && !$completed_form)
				{
					$html_text="PLEASE, COMPLETE THE FORM BEFORE SUBMITTING<br><br><br>".$html_text;
				}
			}
		}
	}

	echo startAndEndHTML($server_base_url, "Register", $html_text, false);
?>