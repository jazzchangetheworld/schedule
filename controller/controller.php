<?php
error_reporting(-1);
ini_set('display_errors', 'On');
	require_once '.././model/db_handler.php';
	require '.././Slim/Slim.php';

	\Slim\Slim::registerAutoloader();

	$app = new \Slim\Slim();

	$db = new db_handler();

	function genTable($result,$cap = '',$nameTable=''){ 
	    $table = '';
		$table.= "<div class='table'>"; 
		$table.=$cap;

		while ($line= $result->fetch_assoc()) { 
			$table.= "<div class=table-row>"; 

			foreach ($line as $key => $value) { 
				if ($key=="id_teacher" and $value != '')  
					$table.= "<div class='cell hidden'><img src='img/calendar.png' class='tarif' id='$value'/></div>";
				elseif ($key == 'id')
					$table.="<div class='cell hidden id'>$value</div>";
				elseif($nameTable == 'discipline'){
					$table.= "<div class='cell hidden touch'>$value</div>
							  <div class='cell hidden'><img src='img/addition.png' id='addition'/></div>";
				}
				else
					$table.= "<div class='cell hidden touch'>$value</div>";
			} 
			$table .= "<div class='cell hidden'><img src='img/del.png' class='delete' name='".$line['id']."' id='$nameTable'></img></div>";
			$table .= "</div>";
		} 
		$table .= "</div>";
		return $table;
	}

	function inspection($value, $nameTable='')	{
		if($value){
	    	echo genTable($value, $nameTable);
	    	exit();
	    } else {
	    	echo "Error";
	    	exit();
	    }
	}

	$app->post('/login', function() use ($app,$db) {
	    session_start();
		$login = $app->request->post('login');
		$password = $app->request->post('password');
		$result = $db->getUser($login);
        if ($result){
			if ($result->num_rows >= 0) {
				//Получаем данные из таблицы
				$row = $result->fetch_assoc();

				if($password === $row['password']) {	
					$_SESSION['user'] = true;
					echo 'true';
				} else
				echo 'false';
			} else
			echo 'false';
        }else echo'false';
	});

	$app->post('/cabinet', function() use ($db) {
	    $res = $db->setAnyDataDB('SELECT * FROM `cabinet`');
	    if($res){
	    	echo genTable($res,'cabinet');
	    } else echo "Error";
	    
	}); 

	$app->post('/cabinet_add', function() use ($app,$db) {
		$numCabinet = $app->request->post('numCabinet');
		$arrCheck = $app->request->post('Checks');
		$db->setAnyDataDB("INSERT INTO `cabinet`(`id`, `name`, `lecture`, `practice`, `own`) VALUES (null,'$numCabinet','$arrCheck[0]','$arrCheck[1]','$arrCheck[2]')");
		$res = $db->setAnyDataDB('SELECT * FROM `cabinet`');
	    if($res){
	    	echo genTable($res,'cabinet');
	    } else echo "Error";
	});

	$app->post('/cabinet_del', function() use ($app,$db) {
		$delCabinets = $app->request->post('deleteCabinets');
		$res = $db->setAnyDataDB("DELETE FROM `cabinet` WHERE `id` IN (".implode(',',$delCabinets).")");
	    if(!$res){echo "Error";};
	});
	
	$app->post('/teacher', function() use ($app,$db) {
	    $res = $db->setAnyDataDB('SELECT teacher.id, teacher.teacher_name, teacher.comment, teacher.staff, tariffing.id_teacher  FROM `teacher` LEFT JOIN `tariffing` ON teacher.id = tariffing.id_teacher');
	    if($res){
	    	
	    	echo genTable($res,'teacher');
	    } else echo "Error";
	}); 

	$app->post('/teacher_add', function() use ($app,$db) {
		$teacher_name = $app->request->post('fioTeacher');
		$comment=$app->request->post('comment');
		$staff=$app->request->post('staff');
		
		if ($staff == 'false') {
			$res = $db->setAnyDataDB("INSERT INTO `teacher`(`id`, `teacher_name`, `comment`, `staff`) VALUES (null, '$teacher_name', '$comment', '-')");

		} else{
			$id = $db->getInsertId("INSERT INTO `teacher`(`id`, `teacher_name`, `comment`, `staff`) VALUES (null, '$teacher_name', '$comment', '+')");

			if (($id - 0) > 0) {
				$db->setAnyDataDB("INSERT INTO `tariffing`(`id_teacher`, `year`, `number_hours`) VALUES (".$id.", '0', '0')");
			}
		}
		$res = $db->setAnyDataDB('SELECT teacher.id, teacher.teacher_name, teacher.comment, teacher.staff, tariffing.id_teacher  FROM `teacher` LEFT JOIN `tariffing` ON teacher.id = tariffing.id_teacher');

		inspection($res,'teacher');
	});

	$app->post('/teacher_del', function() use ($app,$db) {
		$delTeacher = $app->request->post('deleteTeacher');
		$res = $db->setAnyDataDB("DELETE FROM `teacher` WHERE `id` IN (".implode(',',$delTeacher).")");
		$res = $db->setAnyDataDB("DELETE FROM `tariffing` WHERE `id_teacher` IN (".implode(',',$delTeacher).")");		
	});

	$app->post('/type_occupation', function() use ($app,$db) {
		$res = $db->setAnyDataDB('SELECT * FROM `type_occupation`');
	    if($res){
	    	echo genTable($res,'type_occupation');
	    } else echo "Error";
	});

	$app->post('/type_occupation_add', function() use ($app,$db) {
		$occupation = $app->request->post('occupation');
		$db->setAnyDataDB("INSERT INTO `type_occupation`(`id`, `name`) VALUES (null,'$occupation')");
		$res = $db->setAnyDataDB('SELECT * FROM `type_occupation`');
	    if($res){
	    	echo genTable($res,'type_occupation');
	    } else echo "Error";
	});

	$app->post('/discipline', function() use ($app,$db) {
		$res = $db->setAnyDataDB("SELECT * From `discipline`");
	    if($res){
	    	$cap = '<div class="table-row">
						<div class="id cell gr tac tal">id</div>
						<div class="discipline cell gry tac">Дисциплина</div>
						<div class=" predmet cell gr tac">Предмет</div>
	    				<div class="delet cell gr tac">Удалить</div>
					</div>';
	    	$txt = '<input type="button" id="id_addPredmet_btn" value="Добавить">
	           		<input type="text" id="id_type_predmet" value="">'.genTable($res,$cap,'discipline');
	    	echo $txt;
	    } else echo "Error";
	});

	$app->post('/predmet', function() use ($app,$db) {
		$id = $app->request->post('idDiscipline');
		$res = $db->setAnyDataDB("SELECT predmet.id, predmet.name From `predmet` WHERE id_discipline = $id");
	    if($res){
	    	$cap = '<div class="table-row">
						<div class="id cell gr tac tal">id</div>
						<div class=" predmet cell gr tac">Предмет</div>
	    				<div class="delet cell gr tac">Удалить</div>
					</div>';
	    	$txt = '<input type="button" id="id_addPredmet_btn" value="Добавить">
	           		<input type="text" id="id_type_predmet" value="">'.genTable($res,$cap,'predmet');
	    	echo $txt;
	    } else echo "Error";
	});

	$app->post('/delete', function() use ($app,$db) {
		$nameTable = $app->request->post('nameTable');
		$idDelete = $app->request->post('idDelete');
		if($nameTable == 'teacher') {
			$res = $db->setAnyDataDB("DELETE FROM `teacher` WHERE `id` = $idDelete");
			$res = $db->setAnyDataDB("DELETE FROM `tariffing` WHERE `id_teacher` = $idDelete)");
		} else{
			$res = $db->setAnyDataDB("DELETE FROM `$nameTable` WHERE `id` = $idDelete");
		}
	});

	$app->run();
?>