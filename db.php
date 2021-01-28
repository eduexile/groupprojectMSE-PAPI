<?php

	require_once('html_starting_ending.php');

	//$server_base_url = "http://localhost/API/Practica2/"; // local debug
	$server_base_url = "https://apijveron20.000webhostapp.com/API/groupprojectMSE-PAPI/"; // server release

	$server_name = "localhost";
	$user_name = "id14932037_mse_admin";
	$database = "id14932037_mse";
	$password = "segok2H/B!hweH1W";

	$mysqli = new mysqli($server_name, $user_name, $password, $database);

	// Check connection
	if ($mysqli->connect_error) 
	{
	    die("ERROR: " . $mysqli->connect_error);
	}

	function mysql_fix_string($mysqli, string $string)
	{
		if (get_magic_quotes_gpc())
		{
			$string = stripslashes($string);
		}
		return $mysqli->real_escape_string($string);
	}

?>