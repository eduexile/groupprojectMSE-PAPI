<?php

    require_once('crud_user.php');
    require_once('crud_session.php');
    require_once('crud_cart_product.php');

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

            if (isset($_GET['product_id']) && isset($_GET['quantity']) && isset($_GET['origin']))
            {
                insertCartProduct($mysqli, $_GET['quantity'], $user_id, $_GET['product_id'], $_GET['origin']);
                $nextPage = $server_base_url."searchItem.php?product_id=".$_GET['product_id']."&database=".$_GET['origin'];
                echo $nextPage;
                header("Location: $nextPage");
            }
            else
            {
                echo "ERROR";
            }

        }
        else
        {
            $nextPage = $server_base_url."logout.php";
            header("Location: $nextPage");
        }
        
    }
    else
    {
        header("Location: login.php");
    }

?>