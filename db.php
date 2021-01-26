<?php

$hostname = "localhost";
$user = "mseadmin";
$pass = "admin";
$database = "metasearch_engine";

$mysqli = new mysqli($hostname, $user, $pass, $database);

if($mysqli->connect_errno != 0)
{
    die($mysqli->connect_error);
}
    
?>