<?php
	session_start();
	error_reporting(-1);
	ini_set('display_errors', 'On');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
  	<script src="js/jquery.js"></script> 
  	<script src="js/function.js"></script>
  	<script src="js/ajaxQuery.js"></script>
	<link rel="stylesheet" href="css/main.css">
	<title>Document</title>
</head>
<body>
	<?php
		// Проверяем, пусты ли переменные логина и id пользователя
    	$user = isset($_SESSION['user']) ? $_SESSION['user'] : false;
    	if($user === true){
	?>
		<div class="wrapper">
			<div class="header">
				<ul id="menu">
					<li>
						<a href="">Справочники</a>
						<ul class="spr">
							<li><a href="" id='cabinet'>Кабинеты</a></li>
							<li><a href="" id='teacher'>Преподаватели</a></li>
							<li><a href="" id='cycle'>Циклы</a></li>
							<li><a href="" id='group'>Группы</a></li>
							<li><a href="" id='type_occupation'>Тип занятий</a></li>
							<li><a href="" id='predmet'>Предмет</a></li>
						</ul>
					</li>
					<li><a href="">Расписание</a></li>
					<li><a href="">Отчеты</a></li>
					<li>
						<a href="">Настройки</a>
						<ul class="set">
							<li><a href="">Пользователи</a></li>
							<li><a href="">Настройки цвета</a></li>
							<li><a href="">Время занятий</a></li>
							<li><a href="">Количество дней в неделе</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="content"></div>
			<div class="footer"></div>
		</div>	
	<?php
		} else{
	?>
		<div class="wrapper">
			<!-- <div class="header"></div> -->
			<div class="content">
				<div id='form'> 
					<input type="text" id='login' value="Логин" onfocus='if (this.value == "Логин") this.value="";'>
					<input type="password" id='password' value="Пароль" onfocus='if (this.value == "Пароль") this.value="";'>
					<input type="button" id='vhod' value="Ввойти">
				</div> 
			</div>
			<div class="footer"></div>
		</div>
	<?php
		}
	?>
</body>
</html>