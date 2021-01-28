<?php

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

            <form id = 'searchForm' method = 'post' action = ''>
                <label> Search: </label> <br>
                <input type = 'text' id = 'searchingText' oninput = 'performSearchItems(this.value);'>
            </form>
            <form id = 'searchForm' method = 'post' action = ''>
                <label> Search: </label> <br>
                <input type = 'text' id = 'searchingText' oninput = 'performSearchItems(this.value);'>
            </form>";

    $html.= "<button type='button' onclick='changePage();'>Previous Page </button>";
    $html.= "<button type='button' name='nextButton' onclick='changePage(true);'>Next Page </button>
            <br><br>
        <table id=products>
        </table>
        <br><br>
        </body>
    </html>";

    echo $html;

    echo "<script type = 'text/javascript'> performSearchItems(''); </script>";

?>