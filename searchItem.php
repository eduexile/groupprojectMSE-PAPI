<?php

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
                <h3><a href = \"MSE.php\"> > HOME</a></h3>
                <br><br>
            <table id=product>
            </table>
            <br><br>
            <button id=buyButton type=button>Buy</button>
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

?>