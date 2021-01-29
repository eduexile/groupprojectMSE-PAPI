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

            $cart_products = getCartProductsByUserID($mysqli, $user_id);
            
            if (isset($_POST['address']) && strlen($_POST['address']) > 0)
            {
                $user = getUserByID($mysqli, $user_id);

                $html = "<!DOCTYPE html>
                    <html>

                        <head>
                            <title>Metasearch Engine</title>
                        </head>

                        <script src = 'js/buyProducts.js'></script>

                        <body>
                        <a href=''><h1>BUY PRODUCTS IN CART</h1></a>
                        <h3><a href = \"index.php\"> > HOME</a></h3>";

                $totalItems = count($cart_products);

                for ($i = 0; $i < $totalItems; ++$i) 
                { 
                    $html.= "<script type = 'text/javascript'> 
                    performBuyItems('{$user['email']}', {$cart_products[$i]['product_id']}, '{$cart_products[$i]['origin']}', {$cart_products[$i]['quantity']}, '{$_POST['address']}', {$i}, {$totalItems}); </script>";
                }

                $html.= "</body></html>";

                echo $html;
            }
            else
            {
                $html = "<!DOCTYPE html>
                    <html>

                        <head>
                            <title>Metasearch Engine</title>
                        </head>

                        <body>
                        <a href=''><h1>BUY PRODUCTS IN CART</h1></a>
                        <h3><a href = \"index.php\"> > HOME</a></h3>
                        <table id=orders>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Origin</th>
                        </tr>";
                for ($i = 0; $i < count($cart_products); ++$i)
                {
                    $html.= "<tr><td>
                    <a href='searchItem.php?product_id={$cart_products[$i]['product_id']}&database={$cart_products[$i]['origin']}'>{$cart_products[$i]['product_id']}</a>
                    </td><td>
                    {$cart_products[$i]['quantity']}
                    </td><td>
                    {$cart_products[$i]['origin']}
                    </td></tr>";
                }
                $html.= "</table>
                <form id = 'buyForm' method = 'post' action = 'buyProducts.php'>
                    <label>Address: </label>
                    <input type='text' name='address'>
                    <input type = 'submit' value='Buy products'>
                </form>
                </body></html>";

                echo $html;
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