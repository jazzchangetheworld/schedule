//отправить запрос на сервер
	function send(file_str, Data_obj, Succes_func){
		$.ajax({
			type: "GET", 
			async: false,
            url: file_str, 
            data: Data_obj,
            success: Succes_func
		});
	}

//взять значение
	function getVal(id){
		return $(id).val;
	}