
var	URLS = {
    munchking_item: "https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_items.php",

    masks_item: "https://apiecebollero20.000webhostapp.com/PAPI/Practica2/getItemsAsJson.php",

    drinks_item: "https://apijchueca202.000webhostapp.com/IA2_JorgeChueca/getItemAsJSON.php",

    munchking_add: "https://apijveron20.000webhostapp.com/API/Practica2/reduce_stock_json.php",

    masks_add: "https://apiecebollero20.000webhostapp.com/PAPI/Practica2/reduceStockAsJson.php",

    drinks_add: "https://apijchueca202.000webhostapp.com/IA2_JorgeChueca/reduceStockJSON.php"
}

var DATA = {
    table_elements : ["Image", "Price"],
    product : {}
}

var MSE_Credentials = {
    mail: "Bot_101@101server.com",
    pass: "101"
}

function performSearchItem(product_id, database)
{
	var url = "?mail=" + MSE_Credentials.mail + "&pass=" + 
                    MSE_Credentials.pass + "&product_id=" + product_id;
	if (database == 'munchking')
	{
		url = URLS.munchking_item + url;
	}
	else if (database == 'masks')
	{
		url = URLS.masks_item + url;
	}
	else if (database == 'drinks')
	{
		url = URLS.drinks_item + url;
	}
	else
	{
		console.log("Error");
		return;
	}

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            printNewItem(this.responseText);
        }
    }
    xhttp.open('GET', url, true);
    xhttp.send();
}

function printNewItem(response)
{
    generateTableIndexes();
    populate(response);
}

function generateTableIndexes()
{
    var sel = document.getElementById('product');
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

    var title = document.getElementById('title');
    title.innerHTML="";

    var button = document.getElementById('buyButton');
    button.innerHTML="";
}

function populate(data)
{
    if (!data)
    {
        return;
    }

    DATA.product = JSON.parse(data);

    var title = document.getElementById('title');
    var name = document.createElement('h1');
    name.innerHTML = DATA.product.name;
    title.appendChild(name);

    var button = document.getElementById('buyButton');
    button.innerHTML="Add to cart (" + DATA.product.quantity + " left)";

    var sel = document.getElementById('product');
    var tr = document.createElement('tr');

    opt = document.createElement('td');
    opt.innerHTML = "<img src='" + DATA.product.image_url + "' width='300' height='300'>";
    tr.appendChild(opt);

    opt = document.createElement('td');
    opt.innerHTML = DATA.product.price + " €. ";
    tr.appendChild(opt);

    sel.appendChild(tr);
}

function addToCart(product_id, database)
{
    var quantity = document.getElementById('unities').value;

	var url = "?mail=" + MSE_Credentials.mail + "&pass=" + 
                    MSE_Credentials.pass + "&product_id=" + product_id +
                    "&quantity=" + quantity;
	if (database == 'munchking')
	{
		url = URLS.munchking_add + url;
	}
	else if (database == 'masks')
	{
		url = URLS.masks_add + url;
	}
	else if (database == 'drinks')
	{
		url = URLS.drinks_add + url;
	}
	else
	{
		console.log("Error");
		return;
	}

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
        	var response = this.responseText;
            console.log(response);
            var success = JSON.parse(response);

            var button = document.getElementById('buyButton');
    		button.innerHTML="Add to cart (" + DATA.product.quantity + " left)";

            if (success.success == 'true')
            {
                var newUrl = "addToCart.php?product_id=" + product_id + "&quantity=" + quantity + "&origin=" + database;
                window.location.replace(newUrl);
            }
        }
    }
    xhttp.open('GET', url, true);
    xhttp.send();
}