
var	URLS = {
    munchking_items: "https://apijveron20.000webhostapp.com/API/Practica2/search_get_json_items.php",
    masks_items: "https://apiecebollero20.000webhostapp.com/PAPI/Practica2/getItemsAsJson.php"
}

var DATA = {
    table_elements : ["Name", "Quantity", "Price", "Image"],
    products_munchking : [],
    products_masks : []
}

var MSE_Credentials = {
    mail: "Bot_101@101server.com",
    pass: "101"
}



function performSearchItems(searchString)
{
    var searchGet = "?search=" + searchString + "&mail=" + MSE_Credentials.mail + "&pass=" + MSE_Credentials.pass;
    var url_munchking = URLS.munchking_items + searchGet;
    var url_masks = URLS.masks_items + searchGet;

    generateTableIndexes();

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            populateMunchking(this.responseText);
        }
    }
    xhttp.open('GET', url_munchking, true);
    xhttp.send();

    xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            populateMasks(this.responseText);
        }
    }
    xhttp.open('GET', url_masks, true);
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

function populateMunchking(data)
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

function populateMasks(data)
{
    if (!data)
    {
        return;
    }
    DATA.products_masks = JSON.parse(data);

    var sel = document.getElementById('products');
    for(var i = 0; i < DATA.products_masks.length; ++i)
    {
        var tr = document.createElement('tr');

        var opt = document.createElement('td');
        opt.innerHTML = DATA.products_masks[i].name;
        //opt.value = DATA.products_masks[i].name;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.products_masks[i].quantity;
        //opt.value = DATA.products_masks[i].quantity;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = DATA.products_masks[i].price + " €";
        //opt.value = DATA.products_masks[i].price;
        tr.appendChild(opt);

        opt = document.createElement('td');
        opt.innerHTML = "<img src='" + DATA.products_masks[i].image_url + "' width='150' height='150'>";
        //opt.value = DATA.products_masks[i].image_url;
        tr.appendChild(opt);

        sel.appendChild(tr);
    }
}
