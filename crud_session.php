<?php
	
/**************************** SESSION ***************************/

	function getSessions($mysqli)
	{
		$sessions = array();
		$querySelect = "SELECT * FROM session;";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($sessions, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $sessions;
	}

	function getSessionByID($mysqli, int $session_id)
	{
		$querySelect = "SELECT * FROM session WHERE session_id = '{$session_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		$result->data_seek(0);

		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function getSessionsByUserID($mysqli, int $user_id)
	{
		$sessions = array();
		$querySelect = "SELECT * FROM session WHERE user_id = '{$user_id}';";
		$result = $mysqli->query($querySelect);

		if (!$result)
		{
			return false;
		}

		for ($i = 0; $i < $result->num_rows; ++$i)
		{
			$result->data_seek($i);
			array_push($sessions, $result->fetch_array(MYSQLI_ASSOC));
		}

		return $sessions;
	}

	function insertSession($mysqli, int $user_id)
	{
		$current_date = date('Y-m-d')." ".date('H:i:s');
		$stmt = $mysqli->prepare("INSERT INTO session(user_id, date) VALUES (?, ?);");

		$stmt->bind_param("is", $user_id, $current_date);
		$stmt->execute();

		return (int)$mysqli->insert_id;
	}

	function updateSession($mysqli, int $session_id, string $date)
	{
		$date = mysql_fix_string($mysqli, $date);
		$stmt = $mysqli->prepare("UPDATE session SET date=? WHERE session_id='{$session_id}';");

		$stmt->bind_param("s", $date);
		$stmt->execute();
	}

	function deleteSessionByID($mysqli, int $session_id)
	{
		$queryDelete = "DELETE FROM session WHERE session_id='{$session_id}';";
		$result = $mysqli->query($queryDelete);
	}

?>