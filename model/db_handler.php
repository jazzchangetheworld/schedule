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

	public function setAnyDataDB($request)	{
		$stmt = $this->conn->prepare($request);

		if ($stmt->execute()) {
			$result = $stmt->get_result();
			$stmt->close();
			return $result;
		} 
		else{
			$stmt->close();
			return false;
		} 
	}

	public function getInsertId($request){
		$stmt = $this->conn->prepare($request);

		if ($stmt->execute()){
			$id = $stmt->insert_id;
			$stmt->close();
			return $id;
		} 
		else{
			$stmt->close();
			return false;
		} 
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