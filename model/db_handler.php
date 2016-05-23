<?php
error_reporting(-1);
ini_set('display_errors', 'On');
class db_handler {
	
	private $conn;
 
    function __construct() {
        require_once 'db_connect.php';
        
        //открыть соединение с БД
        $db = new db_connect();
        $this->conn = $db->connect();
    }

    //запросить все у заданной таблицы
	public function getAllDataDB($name_table) {
		$stmt = $this->conn->prepare("SELECT * FROM $name_table");
	//	$stmt->bind_param("s", $name_table);
		$stmt->execute();

		$result = $stmt->get_result();
		$stmt->close();
		
		if ($result) return $result;
		else return false;
	}

	public function setAnyDataDB($request)	{
		$stmt = $this->conn->prepare($request);
		$result = $stmt->execute();

		$stmt->close();

		if ($result) return true;
		else return false;
	}

	public function getUser($login)	{
		$stmt = $this->conn->prepare("SELECT * FROM `user` WHERE `login` = '$login'");
		$result = $stmt->execute();

		$result = $stmt->get_result();

		$stmt->close();

		if ($result) return $result;
		else return false;
	}

	
}

?>