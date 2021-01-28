<?php

	function startAndEndHTML(string $server_base_url, string $page_name, string $html_body, bool $logged_in)
	{
		$y_size = 100;
		$x_size = 6.74113475177 * $y_size;

		$html_text = "<!DOCTYPE html>
				<html>
					<head>
						<title>{$page_name}</title>
					</head>
					<body><br><a href='".$server_base_url."'><h1>Veron_Chueca_Cebollero MSE</h1></a><br><br>".
					$html_body."<br><br>";

		if ($logged_in)
		{
			$html_text.= "<form method = 'post' action = 'logout.php'>
							<input type = 'submit' value = 'LOG OUT'><br><br>
						</form>";
		}
		else
		{
			$html_text.="<label> Already got an account? </label>
						<form method = 'post' action = 'login.php'>
							<input type = 'submit' value = 'LOG IN'>
						</form><br>
						<label> New here? </label>
						<form method = 'post' action = 'new_user.php'>
							<input type = 'submit' value = 'REGISTER NOW!'>
						</form><br><br>";
		}

		$html_text.= "</body></html>";

		return $html_text;
	}

?>