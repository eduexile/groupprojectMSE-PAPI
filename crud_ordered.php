<?php

	require_once("db.php");
	
/***************************** ORDERS ****************************/

	function getOrdersByUserID($mysqli, int $user_id)
	{
		$orders = array();
		$querySelect = "SELECT * FROM ordered WHERE user_id = '{$user_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			die($mysqli->error);
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($orders, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $orders;
	}

	function getOrdersByEmail($mysqli, $email)
	{
		$email = mysql_fix_string($mysqli, $email);

		$stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?;");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows == 0)
		{
			return array();
		}

		$result->data_seek(0);

		$currentUser = $result->fetch_array(MYSQLI_ASSOC);

		return getOrdersByUserID($mysqli, $currentUser['user_id']);
	}

	function getOrdersByProductID($mysqli, int $product_id)
	{
		$orders = array();
		$querySelect = "SELECT * FROM ordered WHERE product_id = '{$product_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			die($mysqli->error);
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($orders, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $orders;
	}

	function getOrderByID($mysqli, int $order_id)
	{
		$querySelect = "SELECT * FROM ordered WHERE ordered_id = '{$order_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			die($mysqli->error);
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function insertOrder($mysqli, int $quantity, int $user_id, $direction, int $product_id, $origin)
	{
		$current_date = date('Y-m-d');
		$queryInsert = "INSERT INTO ordered(date, quantity, user_id, direction, product_id, origin) VALUES ('{$current_date}', {$quantity}, {$user_id}, '{$direction}', {$product_id}, '{$origin}');";
		$result = $mysqli->query($queryInsert);

		if (!$result)
		{
			return false;
		}

		return true;
	}

	function deleteOrderByID($mysqli, int $order_id)
	{
		$queryDelete = "DELETE FROM ordered WHERE ordered_id={$order_id}";
		$result = $mysqli->query($queryDelete);

		if (!$result)
		{
			die($mysqli->error);
		}
	}

	function updateOrderByID($mysqli, int $order_id, string $date, string $quantity, int $user_id, int $product_id)
	{
		$updating = false;
		$queryUpdate = "UPDATE ordered";
		if (strlen($date) > 0)
		{
			$updating = true;
			$queryUpdate.= " SET date='{$date}'";
		}
		if (strlen($quantity) > 0)
		{
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
		if (strlen($user_id) > 0)
		{
			if ($updating)
			{
				$queryUpdate.= ", user_id={$user_id}";
			}
			else
			{
				$updating = true;
				$queryUpdate.= " SET user_id={$user_id}";
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

		$queryUpdate.= " WHERE ordered_id={$order_id};";
		$result = $mysqli->query($queryUpdate);

		if (!$result)
		{
			die($mysqli->error);
		}
	}

?>