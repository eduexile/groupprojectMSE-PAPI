<?php

    if (isset($_GET['start']))
    {
        $start = $_GET['start'];
    }
    else
    {
        $start = 0;
    }
    if (isset($_GET['amount']))
    {
        $amount = $_GET['amount'];
    }
    else
    {
        $amount = 1;
    }

    $html = "
        <!DOCTYPE html>
        <html>

            <head>
                <title>Metasearch Engine</title>
            </head>

            <script src = 'js/parseItems.js'></script>

            <body>
            <h1>SEARCH ITEMS</h1>
            <h3><a href = \"MSE.php\"> > HOME</a></h3>

            <form method = 'post' action = ''>
                <label> Search: </label> <br>
                <input type = 'text' oninput = 'performSearchItems(this.value, {$start}, {$amount});'>
            </form>
            <br></br>
            
            <table id=products>
            </table>";

        $html .= "</body>
        </html>
        ";

    echo $html;

    echo "<script type = 'text/javascript'> performSearchItems('', {$start}, {$amount}); </script>  ";
?>