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

            if (isset($_GET['product_id']) && isset($_GET['database']))
            {
                $html = "
                    <!DOCTYPE html>
                    <html>

                        <head>
                            <title>Metasearch Engine</title>
                        </head>

                        <script src = 'js/parseItem.js'></script>

                        <body>
                        <a id=title href=''><h1>ITEM DETAILS</h1><a>
                        <h3><a href = \"index.php\"> > HOME</a></h3>
                        <br><br>
                    <table id=product>
                    </table>
                    <br><br>
                    <form id = 'searchForm' method = 'post' action = ''>
                        <input type = 'number' id = 'unities' value = 1>
                    </form>
                    <button id=buyButton type=button onclick='addToCart({$_GET['product_id']}, \"{$_GET['database']}\");'>Add to cart</button>
                    <br><br>
                    </body>
                </html>";

                echo $html;

                echo "<script type = 'text/javascript'> performSearchItem({$_GET['product_id']}, '{$_GET['database']}'); </script>";
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