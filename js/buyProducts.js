
var	URLS = {
    munchking_buy: "https://apijveron20.000webhostapp.com/API/Practica2/create_order_json.php",

    masks_buy: "https://apiecebollero20.000webhostapp.com/PAPI/Practica2/createOrderAsJson.php",

    drinks_buy: "https://apijchueca202.000webhostapp.com/IA2_JorgeChueca/createOrderJSON.php"
}

var MSE_Credentials = {
    mail: "Bot_101@101server.com",
    pass: "101"
}

function performBuyItems(user_email, product_id, origin, quantity, address, cart_index, cart_count)
{
	var url = "?mail=" + MSE_Credentials.mail + "&pass=" + 
                    MSE_Credentials.pass + "&product_id=" + product_id
                    + "&quantity=" + quantity + "&user_email=" + user_email + "&address=" + address;
	if (origin == 'munchking')
	{
		url = URLS.munchking_buy + url;
	}
	else if (origin == 'masks')
	{
		url = URLS.masks_buy + url;
	}
	else if (origin == 'drinks')
	{
		url = URLS.drinks_buy + url;
	}
	else
	{
		console.log("Error");
		return;
	}

	var createOrderPhp = "createOrder.php" + "?product_id=" + product_id
                    + "&quantity=" + quantity + "&address=" + address + "&origin=" + origin;

	var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) 
        {
            var response = JSON.parse(this.responseText);
            if (response.ordered != 'true')
            {
            	var createOrderXhttp = new XMLHttpRequest();
			    createOrderXhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) 
			        {
			            console.log("successful GA");
			        }
			        else
			        {
			            console.log("wrong");
			        }
			    }
			    createOrderXhttp.open('GET', createOrderPhp, true);
			    createOrderXhttp.send();
            }
            else
            {
            	console.log("successful IA");
            }

            if (cart_index == cart_count - 1)
			{
				// Change page
				window.location.href = "searchOrders.php";
			}
        }
    }
    xhttp.open('GET', url, true);
    xhttp.send();
}