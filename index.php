<?php

    require_once('crud_user.php');
    require_once('crud_session.php');

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

            $nextPage = $server_base_url."searchItems.php";
            header("Location: $nextPage");

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