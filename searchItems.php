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

            $html = "
                <!DOCTYPE html>
                <html>

                    <head>
                        <title>Metasearch Engine</title>
                    </head>

                    <script src = 'js/parseItems.js'></script>

                    <body>
                    <a href=''><h1>SEARCH ITEMS</h1></a>
                    <h3><a href = \"index.php\"> > HOME</a></h3>
                    <form id = 'searchForm' method = 'post' action = ''>
                        <label> Search: </label> <br>
                        <input type = 'text' id = 'searchingText' oninput = 'performSearchItems(this.value);'>
                    </form>
                    <button type='button' onclick='changePage();'>Previous Page </button>
                    <button type='button' name='nextButton' onclick='changePage(true);'>Next Page </button>
                    <br><br>
                    <form method='post'>
                    <p><label>Filter:</label>
                    <select name=filter onchange='performFilter(this.value);'>
                        <option value=''>None</option>
                        <option value='is_mask'>Mask</option>
                        <option value='is_beer'>Beer</option>
                        <option value='is_snack'>Snack</option>
                    </select>
                    <label> Min price: </label>
                    <input type = 'number' onchange = 'limitPrices(this.value, false);' value = 0>
                    <label> Max price: </label>
                    <input type = 'number' onchange = 'limitPrices(this.value, true);' value = 100000>
                    </form>
                    <br><br>
                <table id=products>
                </table>
                <br><br>
                <h2> <a href = \"buyProducts.php\"> BUY PRODUCTS IN CART</a></h2>
                <h2> <a href = \"searchOrders.php\"> VIEW ORDERS</a></h2>
                <h2> <a href = \"GA.pdf\" target='_blank'>EXPLANATION OF PRACTICE</a></h2>

                <h2> <a href = \"logout.php\">LOG OUT</a></h2>
                </body>
            </html>";

            echo $html;

            echo "<script type = 'text/javascript'> performSearchItems(''); </script>";

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