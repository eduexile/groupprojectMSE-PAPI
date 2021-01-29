<?php

	require_once("db.php");

/************************* CART PRODUCTS ************************/

	function getCartProducts($mysqli)
	{
		$orders = array();
		$querySelect = "SELECT * FROM cart_product;";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($orders, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $orders;
	}

	function getCartProductsByUserID($mysqli, int $user_id)
	{
		$orders = array();
		$querySelect = "SELECT * FROM cart_product WHERE user_id = '{$user_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($orders, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $orders;
	}

	function getCartProductByProductID($mysqli, int $product_id)
	{
		$querySelect = "SELECT * FROM cart_product WHERE product_id = '{$product_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function getCartProductByProductIDAndUserID($mysqli, int $product_id, int $user_id, $origin)
	{
		$querySelect = "SELECT * FROM cart_product WHERE product_id = '{$product_id}' AND user_id = '{$user_id}' AND origin = '{$origin}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function getCartProductByID($mysqli, int $cart_product_id)
	{
		$querySelect = "SELECT * FROM cart_product WHERE cart_product_id = '{$cart_product_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function insertCartProduct($mysqli, int $quantity, int $user_id, int $product_id, $origin)
	{
		$existingProduct = getCartProductByProductIDAndUserID($mysqli, $product_id, $user_id, $origin);

		$current_date = date('Y-m-d');

		if (!$existingProduct || is_null($existingProduct))
		{
			$queryInsert = "INSERT INTO cart_product(date, quantity, user_id, product_id, origin) VALUES ('{$current_date}', {$quantity}, {$user_id}, {$product_id}, '{$origin}');";
			$result = $mysqli->query($queryInsert);

			if (!$result)
			{
				return false;
			}

			return (int)$mysqli->insert_id;
		}
		else
		{
			$new_quantity = $existingProduct['quantity'] + $quantity;
			updateCartProductByID($mysqli, $existingProduct['cart_product_id'], $current_date, $new_quantity, "");
		}

		// Update cart dates:
		$all_products = getCartProductsByUserID($mysqli, $user_id);
		foreach ($all_products as $c_product)
		{
			updateCartProductByID($mysqli, $c_product['cart_product_id'], $current_date, "", "");
		}

		return (int)$existingProduct['cart_product_id'];
	}

	function deleteCartProductByID($mysqli, int $cart_product_id)
	{
		$existingProduct = getCartProductByID($mysqli, $cart_product_id);
		$queryDelete = "DELETE FROM cart_product WHERE cart_product_id={$cart_product_id}";
		$result = $mysqli->query($queryDelete);

		if (!$result)
		{
			return false;
		}

		return true;
	}

	function updateCartProductByID($mysqli, int $cart_product_id, string $date, string $quantity, string $product_id)
	{
		$updating = false;
		$queryUpdate = "UPDATE cart_product";
		if (strlen($date) > 0)
		{
			$updating = true;
			$queryUpdate.= " SET date='{$date}'";
		}
		if (strlen($quantity) > 0)
		{
			$existingProduct = getCartProductByID($mysqli, $cart_product_id);

			if ($updating)
			{
				$queryUpdate.= ", quantity={$quantity}";
			}
			else
			{
				$updating = true;
				$queryUpdate.= " SET quantity={$quantity}";
			}
		}
		if (strlen($product_id) > 0)
		{
			if ($updating)
			{
				$queryUpdate.= ", product_id={$product_id}";
			}
			else
			{
				$updating = true;
				$queryUpdate.= " SET product_id={$product_id}";
			}
		}

		$queryUpdate.= " WHERE cart_product_id={$cart_product_id};";
		$result = $mysqli->query($queryUpdate);

		if (!$result)
		{
			return false;
		}
	}

?>