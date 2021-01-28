<?php

	require_once("db.php");
	
/***************************** USERS ****************************/

	function preparePassword(string $rawPassword, string $salt)
	{
    	$start = substr($salt, 0, 4);
    	$ending = substr($salt, 4, 4);
		$saltedPassword = $start.$rawPassword.$ending;
		$hashedPassword = hash('gost-crypto', $saltedPassword);
		return $hashedPassword;
	}

	function getUsersCount($mysqli, bool $unactivated = false, string $searching = "")
	{
		if (strlen($searching) > 0)
		{
			$searching = '%'.mysql_fix_string($mysqli, $searching).'%';
		}

		$querySelect = "SELECT COUNT(*) FROM user";
		$queryConditions = "";
		if ($unactivated)
		{
			$queryConditions.= " WHERE (activated = 0)";
		}
		if (strlen($searching) > 0)
		{
			if (strlen($queryConditions) > 0)
			{
				$queryConditions.= " AND (name LIKE ? OR email LIKE ?)";
			}
			else
			{
				$queryConditions.= " WHERE (name LIKE ? OR email LIKE ?)";
			}
		}
		
		$querySelect.= $queryConditions;

		$stmt = $mysqli->prepare($querySelect);
		if (strlen($searching) > 0)
		{
			$stmt->bind_param("ss", $searching, $searching);
		}

		$stmt->execute();
		$result = $stmt->get_result();

		$result->data_seek(0);
		return $result->fetch_array(MYSQLI_ASSOC)['COUNT(*)'];
	}

	function getUsers($mysqli, int $starting_item, int $num_of_items, bool $unactivated = false, string $searching = "")
	{
		$users = array();

		$searching = '%'.mysql_fix_string($mysqli, $searching).'%';

		$querySelect = "SELECT * FROM user";
		$queryConditions = "";
		if ($unactivated)
		{
			$queryConditions.= " WHERE (activated = 0)";
		}
		if (strlen($searching) > 0)
		{
			if (strlen($queryConditions) > 0)
			{
				$queryConditions.= " AND (name LIKE ? OR email LIKE ?)";
			}
			else
			{
				$queryConditions.= " WHERE (name LIKE ? OR email LIKE ?)";
			}
		}
		
		$querySelect.= $queryConditions;

		$querySelect.= " LIMIT $starting_item, $num_of_items;";

		$stmt = $mysqli->prepare($querySelect);
		if (strlen($searching) > 0)
		{
			$stmt->bind_param("ss", $searching, $searching);
		}

		$stmt->execute();
		$result = $stmt->get_result();

		if (!$result)
		{
			return false;
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($users, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $users;
	}

	function getUserByID($mysqli, int $user_id)
	{
		$querySelect = "SELECT * FROM user WHERE user_id = '{$user_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function getUserByEmail($mysqli, string $email)
	{
		$email = mysql_fix_string($mysqli, $email);

		$stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?;");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if (!$result)
		{
			return false;
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function areEmailAndPasswordValid($mysqli, string $email, string $password, bool &$activated)
	{

		$email = mysql_fix_string($mysqli, $email);
		$password = mysql_fix_string($mysqli, $password);

		$stmt = $mysqli->prepare("SELECT * FROM user WHERE email = ?;");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();

		$result->data_seek(0);

		$currentUser = $result->fetch_array(MYSQLI_ASSOC);
  		
 		if (is_null($currentUser))
		{
			return false;
		}

		$activated = $currentUser["activated"];

		$salt = $currentUser["salt"];

		$hashedPassword = preparePassword($password, $salt);

		return $currentUser['password'] == $hashedPassword;
	}

	function insertUser($mysqli, string $name, string $email, string $password)
	{
		if (getUserByEmail($mysqli, $email))
		{
			return false;
		}

		$name = mysql_fix_string($mysqli, $name);
		$email = mysql_fix_string($mysqli, $email);
		$password = mysql_fix_string($mysqli, $password);

		$validation = rand();
		
		$bytes = openssl_random_pseudo_bytes(4);
    	$hex   = bin2hex($bytes);

		$hashedPassword = preparePassword($password, $hex);

		$stmt = $mysqli->prepare("INSERT INTO user(name, password, salt, email, validation, activated) VALUES (?, ?, ?, ?, ?, false);");

		$stmt->bind_param("ssssi", $name, $hashedPassword, $hex, $email, $validation);
		$stmt->execute();

		return (int)$mysqli->insert_id;
	}

	function deleteUserByID($mysqli, int $user_id)
	{
		$queryDelete = "DELETE FROM user WHERE user_id='{$user_id}'";
		$result = $mysqli->query($queryDelete);

		if (!$result)
		{
			die($mysqli->error);
		}
		else
		{
			$queryDelete = "DELETE FROM direction WHERE user_id='{$user_id}'";
			$result = $mysqli->query($queryDelete);

			if (!$result)
			{
				die($mysqli->error);
			}
			else
			{
				$queryDelete = "DELETE FROM cart_product WHERE user_id='{$user_id}'";
				$result = $mysqli->query($queryDelete);

				if (!$result)
				{
					die($mysqli->error);
				}
				else
				{
					$queryDelete = "DELETE FROM ordered WHERE user_id='{$user_id}'";
					$result = $mysqli->query($queryDelete);

					if (!$result)
					{
						die($mysqli->error);
					}
				}
			}
		}
	}

	function updateUserByID($mysqli, int $user_id, string $name, string $email, string $password)
	{
		$name = mysql_fix_string($mysqli, $name);
		$email = mysql_fix_string($mysqli, $email);
		$password = mysql_fix_string($mysqli, $password);

		$currentUser = getUserByID($mysqli, $user_id);

		$queryUpdate = "UPDATE user SET name=?, password=?, email=? WHERE user_id={$user_id};";
		$stmt = $mysqli->prepare($queryUpdate);

		if (strlen($name) == 0)
		{
			$name = $currentUser["name"];
		}

		if (strlen($password) > 0)
		{
			$salt = $currentUser["salt"];
			$hashedPassword = preparePassword($password, $salt);
		}
		else
		{
			$hashedPassword = $currentUser["password"];
		}

		if (strlen($email) == 0)
		{
			$email = $currentUser["email"];
		}

		$stmt->bind_param("sss", $name, $hashedPassword, $email);
		$stmt->execute();
	}

	function updateUserValidationByID($mysqli, int $user_id, int $validation)
	{
		$queryUpdate = "UPDATE user SET validation={$validation} WHERE user_id={$user_id};";
		$result = $mysqli->query($queryUpdate);

		if (!$result)
		{
			die($mysqli->error);
		}
	}

	function activateUserByID($mysqli, int $user_id, bool $activated)
	{
		$queryUpdate = "UPDATE user SET activated={$activated} WHERE user_id={$user_id};";
		$result = $mysqli->query($queryUpdate);

		if (!$result)
		{
			die($mysqli->error);
		}
	}
	
	

?>