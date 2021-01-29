var expected_responses = 4;

var	URLS = {
    // https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_items.php?search=&mail=Bot_101@101server.com&pass=101&start=1&amount=5&is_snack=true
    munchking_items: "https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_orders.php",
    // https://apiecebollero20.000webhostapp.com/PAPI/Practica2/getItemsAsJson.php?search=&mail=Bot_101@101server.com&pass=101&start=1&amount=5
    masks_items: "https://apiecebollero20.000webhostapp.com/PAPI/Practica2/getOrdersAsJson.php",
    // http://apijchueca202.000webhostapp.com/IA2_JorgeChueca/getItemsAsJSON.php?search=&mail=jchueca96@gmail.com&pass=asdf&start=0&amount=10
    drinks_items: "https://apijchueca202.000webhostapp.com/IA2_JorgeChueca/getOrdersAsJSON.php"
}

var DATA = {
    table_elements : ["Product", "Address", "Quantity", "Shop"],
    orders : []
}

var MSE_Credentials = {
    mail: "Bot_101@101server.com",
    pass: "101"
}

function performGetOrders(email)
{
    var ordersGet = "?user_mail=" + email + "&mail=" + MSE_Credentials.mail + "&pass=" + 
                    MSE_Credentials.pass;

    var url_munchking = URLS.munchking_items + ordersGet;
    var url_masks = URLS.masks_items + ordersGet;
    var url_drinks = URLS.drinks_items + ordersGet;
    var url_mse = "search_get_json_orders.php" + ordersGet;

    var responses = [];

    var xhttpMunchking = new XMLHttpRequest();
    xhttpMunchking.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            responses.push(this.responseText);
            if (responses.length >= expected_responses)
            {
                printNewOrders(responses);
            }
        }
    }
    xhttpMunchking.open('GET', url_munchking, true);
    xhttpMunchking.send();

    var xhttpMasks = new XMLHttpRequest();
    xhttpMasks.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            responses.push(this.responseText);
            if (responses.length >= expected_responses)
            {
                printNewOrders(responses);
            }
        }
    }
    xhttpMasks.open('GET', url_masks, true);
    xhttpMasks.send();

    var xhttpDrinks = new XMLHttpRequest();
    xhttpDrinks.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            responses.push(this.responseText);
            if (responses.length >= expected_responses)
            {
                printNewOrders(responses);
            }
        }
    }
    xhttpDrinks.open('GET', url_drinks, true);
    xhttpDrinks.send();

    var xhttpMSE = new XMLHttpRequest();
    xhttpMSE.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            responses.push(this.responseText);
            if (responses.length >= expected_responses)
            {
                printNewOrders(responses);
            }
        }
    }
    xhttpMSE.open('GET', url_mse, true);
    xhttpMSE.send();
}

function printNewOrders(responses)
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
    var sel = document.getElementById('orders');
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
    console.log(data);
    DATA.orders = JSON.parse(data);

    var sel = document.getElementById('orders');
    for(var i = 0; i < DATA.orders.length; ++i)
    {
        var tr = document.createElement('tr');

        var opt = document.createElement('td');
        opt.innerHTML = "<a href='searchItem.php?product_id=" + DATA.orders[i].product_id + 
            "&database=" + DATA.orders[i].origin + "'>" + DATA.orders[i].product_id + "</a>";
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.orders[i].address;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.orders[i].quantity;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.orders[i].origin;
        tr.appendChild(opt);

        sel.appendChild(tr);
    }
}