 $(document).ready(function() {

	var Url = "controller/controller.php";

	var content = $('.content');

	//проверка на ввод
	function inspection (str) {
		if (str.search('/<?php/i') < 0) {
			return true;
		} else false;
	}

//вход в приложение
	 $('#vhod').on('click', function (e) {
			e.preventDefault();
			var login = content.find('#login').val();
			var password = content.find('#password').val();

			$.ajax({
					type: "POST", 
					async: false,
		            url: "controller/controller.php/login", 
		            data: {login:login, password:password},
		            success: function(data) { 
		                if(data == 'true'){
		                    location.reload();
		                } else {
		                    alert('Неверный логин или пароль!');
		                }
		            }
			});
		});


//удаление строки
	content.on('click', '.delete', function (e){
		e.preventDefault();
		var self = this;

		var nameTable = self.id;
		var idDelete = self.name;
		
		$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/delete", 
	            data: {nameTable:nameTable, idDelete: idDelete},
	            success: function(data) {
	            	$(self).parent().parent().remove();
	            	alert('Удалено');
	            }
		});
		
	});


//вкладка кабинеты
	$('#cabinet').on('click', function (e) {
	    e.preventDefault();
	    $.ajax({
	    	type: "POST", 
	    	async: false,
	        url: "controller/controller.php/cabinet", 
	        data: {},
	        error: function(jqXHR){console.log(jqXHR);},
	        success: function(data) {
	        	content.empty();
	        	content.append('<input type="button" id="id_addCab_btn" value="Добавить">'+
	            						   '<input type="checkbox" class="check" >'+
	            						   '<input type="checkbox" class="check" >'+
	            						   '<input type="checkbox" class="check" >'+
	        						   '<input type="text" id="id_addCab_txt" value="">');
	        	content.append(data); 
	        	$('.table').prepend('<div class="table-row">'+
	    							 	'<div class="id cell gr tac tal">id</div>'+
	    							 	'<div class="cabinet cell gry tac">Номер аудитории</div>'+
	    							 	'<div class="lectory cell gr tac">Лекция</div>'+
	    							 	'<div class="practic cell gr tac">Практика</div>'+
	    								'<div class="owner cell gr tac">Внешний</div>'+
	    								'<div id="cabinet" class="delet cell gr tac">Удалить</div>'+

	    							'</div>');
	        }
	    });
	});

//добавить кабинет
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
		
		    $.ajax({
		    		type: "POST", 
		    		async: false,
	                url: "controller/controller.php/cabinet_add", 
	                data: {numCabinet:newtxt, Checks:arrCheck},
	                success: function(data) { 
	                	$('.table').remove();
	                	content.append(data); 
	                	$('.table').prepend('<div class="table-row">'+
		    								 	'<div class="id cell gr tac tal">id</div>'+
		    								 	'<div class="cabinet cell gry tac">Номер аудитории</div>'+
		    								 	'<div class="lectory cell gr tac">Лекция</div>'+
		    								 	'<div class="practic cell gr tac">Практика</div>'+
		    									'<div class="owner cell gr tac">Внешний</div>'+
	    										'<div id="cabinet" class="delet cell gr tac">Удалить</div>'+
		    								'</div>');
	                	alert('Кабинет добавлен!');
    
	                }
		    	});
		}
		
	});
	
	//преподователи
	$('#teacher').on('click', function (e){
	    e.preventDefault();
		$.ajax({
			type: "POST", 
		    async: false,
	        url: "controller/controller.php/teacher",
	        error: function(jqXHR ){console.log(jqXHR);},
	        success: function(data) {
	         	        content.empty();
	           	        content.append('<input type="button" id="id_addTeacher_btn" value="Добавить">'+
	           						   '<input type="text" id="id_addTeacher_name" value="">'+
	           						   '<input type="text" id="id_addTeacher_comment" value="">'+
	           						   '<input type="checkbox" id="id_addTeacher_staff" value="">');
	           	        content.append(data); 
	           	        $('.table').prepend('<div class="table-row">'+
						  			 	        '<div class="id cell gr tac tal">id</div>'+
									 	        '<div class="fio cell gry tac">ФИО</div>'+
									 	        '<div class="comment cell gr tac">Комментарий</div>'+
									 	        '<div class="staff cell gr tac">Штат</div>'+
									 	        '<div class="tariffing cell gr tac">Тарификация</div>'+
	    										'<div id="teachet" class="delet cell gr tac">Удалить</div>'+
									 	    '</div>');
	           }
			});
	});
	
	//добавление преподователя
	content.on('click', '#id_addTeacher_btn', function (e){
		e.preventDefault();
		var fio = content.find('#id_addTeacher_name').val();
		var Staff = content.find('#id_addTeacher_staff').prop('checked');
		var Comment = content.find('#id_addTeacher_comment').val();

		if(fio == '') {
			alert('Введите ФИО!');
			return;
		} else{
		    $.ajax({
		    	type: "POST", 
		    	async: false,
	            url: "controller/controller.php/teacher_add", 
	            data: {fioTeacher:fio, staff:Staff, comment:Comment},
	            success: function(data) { 
	               	$('.table').remove();
	               	content.append(data); 
	                $('.table').prepend('<div class="table-row">'+
					  			 	    '<div class="id cell gr tac tal">id</div>'+
								 	    '<div class="fio cell gry tac">ФИО</div>'+
								 	    '<div class="comment cell gr tac">Комментарий</div>'+
								 	    '<div class="staff cell gr tac">Штат</div>'+
								 	    '<div class="tariffing cell gr tac">Тарификация</div>'+
	    								'<div id="teachet" class="delet cell gr tac">Удалить</div>'+
						          '</div>');     
	               	alert('Преподаватель добавлен!');

	                }
		    	});
		}
		
	});

//открытие окна тарифиикайций преподователя
 content.on('click', '.tarif', function(e){
 	e.preventDefault();
 	alert('в ожиданий модального окна');
 });

//типы занятий
 $('#type_occupation').on('click', function(e){
 	e.preventDefault();

 	$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/type_occupation", 
	            success: function(data) {
	            	content.empty();
	           	        content.append('<input type="button" id="id_addType_occupation_btn" value="Добавить">'+
	           						   '<input type="text" id="id_type_occupation_name" value="">');
	           	        content.append(data); 
	           	        $('.table').prepend('<div class="table-row">'+
						  			 	        '<div class="id cell gr tac tal">id</div>'+
									 	        '<div class="type_occupation cell gry tac">Тип занятия</div>'+
	    										'<div id="type_occupation" class="delet cell gr tac">Удалить</div>'+
									 	    '</div>');
	            }
		});
 })

 content.on('click','#id_addType_occupation_btn', function(e){
 	e.preventDefault();

 	var occupation = $('#id_type_occupation_name').val();

 	if (occupation == '') {
 		alert("Введите тип занятия!");
 		return;
 	} else{
 		$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/type_occupation_add", 
	            data:{occupation:occupation},
	            success: function(data) {
	            	content.empty();
	           	        content.append('<input type="button" id="id_type_occupation_btn" value="Добавить">'+
	           						   '<input type="text" id="id_type_occupation_name" value="">');
	           	        content.append(data); 
	           	        $('.table').prepend('<div class="table-row">'+
						  			 	        '<div class="id cell gr tac tal">id</div>'+
									 	        '<div class="type_occupation cell gry tac">Тип занятия</div>'+
	    										'<div id="type_occupation" class="delet cell gr tac">Удалить</div>'+
									 	    '</div>');

	            }
		});
 	}
 })

 $('#predmet').on('click', function(e){
 	e.preventDefault();

 	$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/discipline", 
	            success: function(data) {
	            	content.empty();
	           	    content.append(data);
	            }
		});
 })

 content.on('click','#addition', function(e){
 	e.preventDefault();
 	$('.modal_window').show();
 		$.ajax({
				type: "POST", 
				async: false,
	            url: "controller/controller.php/predmet", 
	            data:{idDiscipline:$(this).parent().parent().find('.id')[0].innerHTML},
	            success: function(data) {
	            	$('.content_window').append(data);
	            }
		});
 	
 })

 $(".close").click(function(e){
        
        $('.modal_window').hide();
       	$(this).parent().find('.content_window').empty();
 });

});