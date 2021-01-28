
var	URLS = {
    // https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_items.php?search=&mail=Bot_101@101server.com&pass=101&start=1&amount=5
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

function performSearchItems(searchString, start, amount)
{
console.log(searchString);
console.log(start);
console.log(amount);

    var searchGet = "?search=" + searchString + "&mail=" + MSE_Credentials.mail + "&pass=" + MSE_Credentials.pass + "&start=" + start + "&amount=" + amount;

    var url_munchking = URLS.munchking_items + searchGet;
    var url_masks = URLS.masks_items + searchGet;
    var url_drinks = URLS.drinks_items + searchGet;

    generateTableIndexes();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            populate(this.responseText);
        }
    }
    xhttp.open('GET', url_munchking, true);
    xhttp.send();

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            populate(this.responseText);
        }
    }
    xhttp.open('GET', url_masks, true);
    xhttp.send();

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            populate(this.responseText);
        }
    }
    xhttp.open('GET', url_drinks, true);
    xhttp.send();
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
