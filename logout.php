<?php

	require_once('db.php');
	require_once('crud_session.php');
	session_start();

	$html_text = "";

	if (isset($_SESSION['login']))
	{
		deleteSessionByID($mysqli, $_SESSION['login']);
		$_SESSION = array();
		setCookie(session_name(), '', time() - 100000, '/');
		session_destroy();
		$html_text.= "<p> Logging out... </p> <br><br>
			<form method = 'post' action = 'login.php'>
							<input type = 'submit' value = 'LOG IN'>
						</form>";

		$nextPage = $server_base_url."login.php";
		header("Location: $nextPage");
	}
	else
	{
		$nextPage = $server_base_url;
		header("Location: $nextPage");
	}

?>