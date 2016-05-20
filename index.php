<!--<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <script src="js/jquery.js"></script> 
  <script src="js/function.js"></script>
  <script src="js/ajaxQuery.js"></script>
  <link rel="stylesheet" type="text/css" href="css/main.css">
</head>
<body>
 
	<button id='cabinet'>Кабинеты</button>	
	<button id='teacher'>Преподаватели</button>	
	<button id='cycle'>Циклы</button>	
	<button id='group'>Группы</button>	
	<button id='type_occupation'>Тип занятий</button>						
	<button id='schedule'>Расписание</button>	
	<button id='othet'>Отчеты</button>	
	
	<div id='container'></div> 
</body>
</html>-->


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
</body>
</html>