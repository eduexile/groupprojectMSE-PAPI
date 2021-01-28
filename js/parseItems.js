var start = 0;
var amount = 3;
var searching = "";
var min_price = 0;
var max_price = 1000000000;
var is_beer = false;
var is_snack = false;
var is_mask = false;
var expected_responses = 3;

var	URLS = {
    // https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_items.php?search=&mail=Bot_101@101server.com&pass=101&start=1&amount=5&is_snack=true
    munchking_items: "https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_items.php",
    // https://apiecebollero20.000webhostapp.com/PAPI/Practica2/getItemsAsJson.php?search=&mail=Bot_101@101server.com&pass=101&start=1&amount=5
    masks_items: "https://apiecebollero20.000webhostapp.com/PAPI/Practica2/getItemsAsJson.php",
    // http://apijchueca202.000webhostapp.com/IA2_JorgeChueca/getItemsAsJSON.php?search=&mail=jchueca96@gmail.com&pass=asdf&start=0&amount=10
    drinks_items: "http://apijchueca202.000webhostapp.com/IA2_JorgeChueca/getItemsAsJSON.php"
}

var DATA = {
    table_elements : ["Name", "Quantity", "Price", "Image"],
    products_munchking : [],
    products_masks : [],
    products_drinks : []
}

var MSE_Credentials = {
    mail: "Bot_101@101server.com",
    pass: "101"
}

function changePage(next = false)
{
    if (next)
    {
        start += amount;
    }
    else
    {
        start = Math.max(start - amount, 0);
    }
    performSearchItems(searching);
}

function performSearchItems(searchString)
{
    if (searching != searchString)
    {
        start = 0;
    }
    searching = searchString;
    var searchGet = "?search=" + searching + "&mail=" + MSE_Credentials.mail + "&pass=" + 
                    MSE_Credentials.pass + "&start=" + start + "&amount=" + amount;

    var url_munchking = URLS.munchking_items + searchGet + "&is_snack=" + is_snack;
    var url_masks = URLS.masks_items + searchGet + "&is_mask=" + is_mask;
    var url_drinks = URLS.drinks_items + searchGet + "&is_beer=" + is_beer;

    var responses = [];

    if (!is_mask && !is_beer)
    {
        var xhttpMunchking = new XMLHttpRequest();
        xhttpMunchking.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                responses.push(this.responseText);
                if (responses.length >= expected_responses)
                {
                    printNewItems(responses);
                }
            }
        }
        xhttpMunchking.open('GET', url_munchking, true);
        xhttpMunchking.send();
    }

    if (!is_snack && !is_beer)
    {
        var xhttpMasks = new XMLHttpRequest();
        xhttpMasks.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                responses.push(this.responseText);
                if (responses.length >= expected_responses)
                {
                    printNewItems(responses);
                }
            }
        }
        xhttpMasks.open('GET', url_masks, true);
        xhttpMasks.send();
    }
    
    if (!is_snack && !is_mask)
    {
        var xhttpDrinks = new XMLHttpRequest();
        xhttpDrinks.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) 
            {
                responses.push(this.responseText);
                if (responses.length >= expected_responses)
                {
                    printNewItems(responses);
                }
            }
        }
        xhttpDrinks.open('GET', url_drinks, true);
        xhttpDrinks.send();
    }
}

function printNewItems(responses)
{
    // cls
    generateTableIndexes();

    // print
    for (var i = 0; i < responses.length; ++i) 
    {
        populate(responses[i]);
    }
}

function generateTableIndexes()
{
    var sel = document.getElementById('products');
    sel.innerHTML="";
    var tr = document.createElement('tr');
    tr.id = "trheader";
    
    for(var i = 0; i < DATA.table_elements.length; ++i) 
    {
        var opt = document.createElement('th');
        opt.innerHTML = DATA.table_elements[i];
        opt.value = DATA.table_elements[i];
        tr.appendChild(opt);
    }

    sel.appendChild(tr);
}

function populate(data)
{
    if (!data)
    {
        return;
    }
    DATA.products_munchking = JSON.parse(data);

    var sel = document.getElementById('products');
    for(var i = 0; i < DATA.products_munchking.length; ++i)
    {
        var tr = document.createElement('tr');

        var opt = document.createElement('td');
        opt.innerHTML = DATA.products_munchking[i].name;
        //opt.value = DATA.products_munchking[i].name;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.products_munchking[i].quantity;
        //opt.value = DATA.products_munchking[i].quantity;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.products_munchking[i].price + " €";
        //opt.value = DATA.products_munchking[i].price;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = "<img src='" + DATA.products_munchking[i].image_url + "' width='150' height='150'>";
        //opt.value = DATA.products_munchking[i].image_url;
        tr.appendChild(opt);

        sel.appendChild(tr);
    }
}

function performFilter(filter)
{
    is_beer = false;
    is_snack = false;
    is_mask = false;
    expected_responses = 3;

    if (filter == 'is_beer')
    {
        expected_responses = 1;
        is_beer = true;
    }
    else if (filter == 'is_snack')
    {
        expected_responses = 1;
        is_snack = true;
    }
    else if (filter == 'is_mask')
    {
        expected_responses = 1;
        is_mask = true;
    }

    start = 0;
    performSearchItems(searching);
}

function limitPrices(num, is_max)
{
    if(is_max)
    {
        max_price = num;
    }
    else
    {
        min_price = num;
    }

    start = 0;
    performSearchItems(searching);
}