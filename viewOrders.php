<?php

session_start();

if(isset($_SESSION['login']) && isset($_COOKIE['login']))
{
    $html = "
    <!DOCTYPE html>
    <html>

        <head>
            <title>Metasearch Engine</title>
        </head>

        <script src = 'js/parseOrders.js'></script>

        <body>
        <h1>VIEW ORDERS</h1>
        <h3><a href = \"MSE.php\"> > HOME</a></h3>

        <h3> Click Here to show your orders </h3>
        <button onclick = 'performSearchOrders(\"{$_COOKIE['user']}\");'> Show Orders </button>
        
        <br></br>
        
        <table id=orders>
        </table>";

    $html .= "</body>
    </html>
    ";

echo $html;

}

else
{

    echo "<h3> Please, login or register in our metasearch engine. </h3>
          <br></br>
          <h3><a href = \"MSE.php\"> > HOME</a></h3>";

}





?>