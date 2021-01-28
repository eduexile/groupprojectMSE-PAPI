<?php

    $html = "
        <!DOCTYPE html>
        <html>

            <head>
                <title>Metasearch Engine</title>
            </head>

            <script src = 'js/parseItems.js'></script>

            <body>
            <a href=''><h1>SEARCH ITEMS</h1><a>
            <h3><a href = \"MSE.php\"> > HOME</a></h3>
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
            <input type = 'number' onchange = 'limitPrices(this.value, false);'>
            <label> Max price: </label>
            <input type = 'number' onchange = 'limitPrices(this.value, true);'>
            </form>
            <br><br>
        <table id=products>
        </table>
        <br><br>
        </body>
    </html>";

    echo $html;

    echo "<script type = 'text/javascript'> performSearchItems(''); </script>";

?>