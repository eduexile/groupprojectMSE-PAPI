<?php

session_start();

$html = "
<!DOCTYPE html>
<html>

    <head>
        <title>Metasearch Engine</title>
    </head>

    <body>
    <h1>METASEARCH ENGINE</h1>
    <h2> <a href = \"userRegistration.php\">Register</a></h2>
    <h2> <a href = \"userLogin.php\">Login</a></h2>
    <h2> <a href = \"searchItems.php\"> SEARCH</a></h2>
    <h2> <a href = \"viewOrders.php\"> VIEW ORDERS</a></h2>
    <h2> <a href = \"viewFilterProducts.php\"> FILTER PRODUCTS</a></h2>

    <h2> <a href = \"GA.pdf\">ENUNCIADO DE LA PRACTIQUISIMA</a></h2>";

    // if(isset($_SESSION['login']) && isset($_COOKIE['login']))
    // {
    //     if($_COOKIE['login'] == 1)
    //     {
    //         $html .= "<h2> <a href = \"userLogout.php\"> > Log Out</a></h2>";
    //     }
    // }


$html .= "</body>
</html>
";

echo $html;

?>