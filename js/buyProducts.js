var fullyReady = true;

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
	if (cart_index == 0)
	{
		fullyReady = true;
	}

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
            var responseIA = JSON.parse(this.responseText);
            if (responseIA.ordered != 'true')
            {
            	var createOrderXhttp = new XMLHttpRequest();
			    createOrderXhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) 
			        {
			        	console.log(this.responseText);
			        	var responseGA = JSON.parse(this.responseText);
			        	if (responseGA.ordered == 'true')
            			{
			            	console.log("successful GA(" + this.responseText + "): " + createOrderPhp);
			        	}
			        	else
				        {
				            console.log("wrong(" + responseIA.error + "): " + url);
				        }
				        fullyReady = fullyReady & responseGA.ordered;
			        }
			    }
			    createOrderXhttp.open('GET', createOrderPhp, true);
			    createOrderXhttp.send();
            }
            else
            {
            	console.log("successful IA (" + this.responseText + "): " + url);
            }

            if (cart_index == cart_count - 1)
			{
				if (fullyReady)
				{
					// Change page
					window.location.href = "searchOrders.php?clear_cart=true";
				}
			}
        }
    }
    xhttp.open('GET', url, true);
    xhttp.send();

	console.log("Entered " + (cart_index+1) + " times.");

	return;
}