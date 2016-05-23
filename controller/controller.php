<?php
error_reporting(-1);
ini_set('display_errors', 'On');
	require_once '.././model/db_handler.php';
	require '.././Slim/Slim.php';

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	$db = new db_handler();


	/* Пример запроса 
	$result=mysql_query("SELECT * FROM table_name") 
	*/ 


	function genTable($result){ 
	    $table = '';
		$table.= "<div class='table'>"; 
		while ($line= $result->fetch_assoc()) { 
			$table.= "<div class=table-row>"; 
			foreach ($line as $key => $value) { 
				if ($key=="id_cabinet") 
					$table.= "<div class='cell hidden'>$value</div>"; 
				else $table.= "<div class='cell'>$value</div>"; 
			} 
			$table .= "</div>";
		} 
		$table .= "</div>";
		return $table;
	}



	$app->post('/cabinet', function() use ($db) {
	    $res = $db->getAllDataDB('cabinet');
	    echo genTable($res);
	}); 

	$app->post('/cabinet_add', function() use ($app,$db) {
		$numCabinet = $app->request->post('numCabinet');
		$arrCheck = $app->request->post('Checks');
		$db->setAnyDataDB("INSERT INTO `cabinet`(`id_cabinet`, `name`, `lecture`, `practice`, `own`) VALUES (null,'$numCabinet','$arrCheck[0]','$arrCheck[1]','$arrCheck[2]')");
		$res = $db->getAllDataDB('cabinet');
	    echo genTable($res);
	});

	$app->post('/cabinet_del', function() use ($app,$db) {
		$delCabinets = $app->request->post('deleteCabinets');
		$db->setAnyDataDB("DELETE FROM `cabinet` WHERE `id_cabinet` IN (".implode(',',$delCabinets).")");
	});

	$app->post('/login', function() use ($app,$db) {
		$login = $app->request->post('login');
		$password = $app->request->post('password');
		$result = $db->getUser($login);

		if($result->num_rows > 0) {
			//Получаем данные из таблицы
			$row = $result->fetch_assoc();

			if($password === $row['password']) {	
				$_SESSION['user'] = true;
				echo 'true';
			} else
				echo 'false1';
		} else
			echo 'false2';
	});



	$app->run();
?>