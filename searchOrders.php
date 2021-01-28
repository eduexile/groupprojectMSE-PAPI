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

            $user = getUserByID($mysqli, $user_id);

            $html = "
                <!DOCTYPE html>
                <html>

                    <head>
                        <title>Metasearch Engine</title>
                    </head>

                    <script src = 'js/parseOrders.js'></script>

                    <body>
                    <a href=''><h1>SEE ORDERS</h1></a>
                    <h3><a href = \"index.php\"> > HOME</a></h3>
                    
                    <br><br>
                <table id=orders>
                </table>
                <br><br>
                </body>
            </html>";

            echo $html;

            echo "<script type = 'text/javascript'> performGetOrders('{$user['email']}'); </script>";

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