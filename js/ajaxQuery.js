 $(document).ready(function() {

	var Url = "controller/controller.php";

	//проверка на ввод
	function inspection (str) {
		if (str.search('/<?php/i') < 0) {
			return true;
		} else false;
	}

	var content = $('.content');


	$('#cabinet').on('click', function (e) {
			e.preventDefault();
			$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/cabinet", 
	            data: {},
	            error: function(jqXHR ){console.log('error');},
	            success: function(data) {
	            	content.empty();
	            	content.append('<input type="button" id="id_addCab_btn" value="Добавить">'+
	            						   '<input type="text" id="id_addCab_txt" value="">'+
	            						   '<input type="checkbox" class="check" >'+
	            						   '<input type="checkbox" class="check" >'+
	            						   '<input type="checkbox" class="check" >'+
	            						   '<input type="button" id="id_delCab_btn" value="Удалить">');
	            	content.append(data); 
	            	$('.table').prepend('<div class="table-row">'+
										 	'<div class="id cell gr tac tal">id</div>'+
										 	'<div class="cabinet cell gry tac">Номер аудитории</div>'+
										 	'<div class="lectory cell gr tac">Лекция</div>'+
										 	'<div class="practic cell gr tac">Практика</div>'+
											'<div class="owner cell gr tac">Внешний</div>'+
										'</div>');
	            }
			});
	});

	content.on('click', '#id_addCab_btn', function (e){
		e.preventDefault();
		var arrCheck = [];

		var txt = content.find('#id_addCab_txt').val();

		var newtxt = $.trim(txt);
		alert(newtxt);
		if(newtxt === '') {
			alert('Введите номер кабинета!');
			return;
		} else{
			var row = document.getElementsByClassName('check');
			for (var i = 0; i < row.length; i++) {
				arrCheck[i] = row[i].checked ? "+" : "-";
			};
		}
		$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/cabinet_add", 
	            data: {numCabinet:newtxt, Checks:arrCheck},
	            success: function(data) { 
	            	var table = $('.table');
	            	table.remove();
	            	content.append(data); 
	            	table.prepend('<div class="table-row">'+
										 	'<div class="id cell gr tac tal">id</div>'+
										 	'<div class="cabinet cell gry tac">Номер аудитории</div>'+
										 	'<div class="lectory cell gr tac">Лекция</div>'+
										 	'<div class="practic cell gr tac">Практика</div>'+
											'<div class="owner cell gr tac">Внешний</div>'+
										'</div>');
	            	alert('Кабинет добавлен!');

	            }
			});

		
	});

	content.on('click', '.table-row', function (e){
		$(this).toggleClass("delete");
	});

	content.on('click', '#id_delCab_btn', function (e){
		var rows = $('.delete');
		var deleteRows = [];
		for (var i = 0; i < rows.length; i++) {
			deleteRows[i] = rows.find('.hidden')[i].innerHTML;
		};
		rows.remove();
		$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/cabinet_del", 
	            data: {deleteCabinets:deleteRows},
	            success: function(data) { 
	            	rows.remove();
	            	alert('Кабинет(ы) удален(ы)!');
	            }
			});
		
	});
});