<?php

/**
* 
*/
class db_connect {
	
	private $conn;
 
    function __construct() {        
    }
 
    function connect() {
        include_once 'config.php';
 
        // соединение с БД
        $this->conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
        // првоерка на наличия ошибок
        if (mysqli_connect_errno()) {
            echo "Ошибка подключения: " . mysqli_connect_error();
        }
 
        return $this->conn;
    }

}

?>