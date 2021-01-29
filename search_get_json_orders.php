<?php

    require_once("crud_user.php");
    require_once("crud_ordered.php");

    $activated = true;
    if(!areEmailAndPasswordValid($mysqli, $_GET['mail'], $_GET['pass'], $activated))
    {
        echo "<p> The information you entered is incorrect. Please try again. </p>";
    }
    else if(isset($_GET['user_mail']))
    {
        $user_mail = mysql_fix_string($mysqli, $_GET['user_mail']);

        $data = getOrdersAsJson($mysqli, $user_mail);

        header('Access-Control-Allow-Origin: *');
        header('content-type: application/json; charset=utf-8');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        echo $data;
    }
    else
    {
        echo "ERROR";
    }

    function getOrdersAsJson($mysqli, $user_mail)
    {
        $orders = getOrdersByEmail($mysqli, $user_mail);

        for ($i=0; $i < count($orders); $i++) { 
            $orders[$i]['address'] = $orders[$i]['direction'];
        }

        return json_encode($orders);
    }

?>