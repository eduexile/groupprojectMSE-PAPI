<?php

    require_once('crud_user.php');
    require_once('crud_session.php');
    require_once('crud_ordered.php');

    session_start();

    if (isset($_SESSION['login']))
    {
        if (getSessionByID($mysqli, $_SESSION['login']))
        {
            $session_id = $_SESSION['login'];
            $user_id = getSessionByID($mysqli, $_SESSION['login'])["user_id"];
            deleteSessionByID($mysqli, $session_id);
            $session_id = insertSession($mysqli, $user_id);
            $_SESSION['login'] = $session_id;

            if (isset($_GET['product_id']) && isset($_GET['quantity'])
            	&& isset($_GET['address']) && isset($_GET['origin']))
            {
	            header('Access-Control-Allow-Origin: *');
		        header('content-type: application/json; charset=utf-8');
		        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
		        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
                if (insertOrder($mysqli, $_GET['quantity'], $user_id, $_GET['address'], $_GET['product_id'], $_GET['origin']))
                {
                    echo '{"ordered":"true"}';
                }
                else
                {
                    echo '{"ordered":"false", "error":"{'.$mysqli->error.'}"}';
                }
            }
        }
    }

?>